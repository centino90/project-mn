<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Profiles extends Controller
{
    public function __construct()
    {
        $this->userModel = $this->model('User');
        $this->duesModel = $this->model('Dues');
        $this->profileModel = $this->model('Profile');

        $this->sessionManager = new SessionManager;
        $this->image = new Image;

        parent::__construct();

        $this->session->start();

        if (!$this->isLoggedin() || !$this->isEmailVerified()) {
            $this->url->redirectToLoginpage();
        }

        if ($this->isLoggedIn() && !$this->isCompleteInfo() && $this->isPasswordRegistered()) {
            $this->url->redirect('users/registerPrcInfo');
        }
    }

    public function index()
    {
        $data = [
            'current_route' => __FUNCTION__,
        ];

        $this->url->redirect('profiles/userInfo');
    }
    public function paymentHistory()
    {
        $dues = $this->duesModel->getUserYearlyPayments(['user_id' => $this->session->auth()->profile_id]);

        $data = [
            'current_route' => __FUNCTION__,
            'dues' => $dues,
            'years' => generateYearsBetween()
        ];

        $this->view('profiles/paymentHistory', $data);
    }
    public function userInfo()
    {
        $user = $this->session->auth(false);

        $data = [
            'current_route' => __FUNCTION__,

            'has_facebook_auth' => !empty($user->fb_user_id) ? true : false,
            'has_google_auth' => !empty($user->google_user_id) ? true : false,
            'has_password' => !empty($user->password) ? true : false,
            'has_email' => !empty($user->email) ? true : false,


            'profile_image_path' => $user->profile_img_path,
            'email' => $user->email,
            'user' => $user
        ];

        $this->view('profiles/userInfo', $data);
    }

    public function changePassword()
    {
        try {
            $user = $this->session->auth(false);

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType !== "application/json") {
                throw new Error('Your content type must be in \'application/json\'');
            }

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $decoded['message'] = 'Password was successfully updated!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            // check inputs
            $verifiedUser = $this->userModel->find(
                ['*', 'accounts.id AS id'],
                ['email', 'email_verified'],
                [$this->session->auth()->email, true]
            );
            $hashed_password = $verifiedUser->password;
            if (empty($decoded['profile']['old_password'])) {
                $decoded['errors']['old_password_err'] = 'Please enter old password';
            } else {
                if (!password_verify($decoded['profile']['old_password'], $hashed_password)) {
                    $decoded['errors']['old_password_err'] = 'Old Password incorrect';
                }
            }

            if (empty($decoded['profile']['password'])) {
                $decoded['errors']['password_err'] = 'Please enter new password';
            } elseif (strlen($decoded['profile']['password']) < 6) {
                $decoded['errors']['password_err'] = 'Password must be at least 6 characters';
            }
            if (empty($decoded['profile']['confirm_password'])) {
                $decoded['errors']['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($decoded['profile']['password'] != $decoded['profile']['confirm_password']) {
                    $decoded['errors']['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if (sizeof($decoded['errors']) > 0) {
                throw new Error('You have some input errors. Please check your inputs');
            }

            $decoded['profile']['hashed_password'] = password_hash($decoded['profile']['password'], PASSWORD_DEFAULT);
            if (!$this->userModel->update4(
                [
                    'password'
                ],
                [
                    $decoded['profile']['hashed_password'],
                ],
                ['id'],
                [$this->session->auth()->id]
            )) {
                throw new Error('Something went wrong with the updating of the password. Try again');
            }

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }
    public function profileImage()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if (strpos($contentType, 'multipart/form-data') === false) {
                throw new Error('Your content type must be in \'multipart/form-data\'');
            }

            $decoded = $_POST;

            $decoded['profile_img'] = $_FILES['profile_img'];
            $decoded['message'] = 'Profile image was successfully added!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            if (!isset($decoded["profile_img"]['name'])) {
                throw new Error('You must submit an image to proceed.');
            }
            if (!isset($decoded["user_id"]) || empty($decoded['user_id'])) {
                throw new Error('You must submit a user_id.');
            }

            $filesizeInMb = round(filesize($decoded["profile_img"]['tmp_name']) / 1024 / 1024, 1);
            if ($filesizeInMb > 2) {
                throw new Error('File size limit is only 2 MB. Try again');
            }

            $allowFileExtensions = [
                'png',
                'jpg',
                'webp',
                'gif'
            ];
            $file_array = explode(".", $decoded["profile_img"]["name"]);
            $file_extension = strtolower(end($file_array));

            if (!in_array($file_extension, $allowFileExtensions)) {
                throw new Error('The file format of the file you submitted is not valid. You must follow these following formats (.png, .jpg, .gif, and .webp)');
            }

            $user = $this->userModel->findUserProfile(
                ['*', 'accounts.id AS id'],
                ['profile_id'],
                [$decoded['user_id']]
            );

            $decoded['filename'] = $user->first_name . '-' . time() . '.' . 'webp';

            // full-sized img
            $fullsized = $this->image
                ->start($decoded["profile_img"]['tmp_name'], $decoded['filename'])
                ->repurpose(500, 500)
                ->save(Image::IMAGE_DIRECTORY, 15);

            $thumb = $this->image
                ->start($decoded["profile_img"]['tmp_name'], $decoded['filename'])
                ->repurpose(50, 50)
                ->save(Image::IMAGE_THUMBNAIL_DIRECTORY, 25);
            
                // echo Image::IMAGE_ROOT;
                // dd(Image::IMAGE_THUMBNAIL_ROOT);

            // check if user already has profile img
            if (!empty($user->profile_img_path)) {
                $decoded['message'] = 'Profile image was successfully updated!';
                unlink($user->profile_img_path);
            }
            if (!empty($user->thumbnail_img_path)) {
                $decoded['message'] = 'Profile image was successfully updated!';
                unlink($user->thumbnail_img_path);
            }

            $decoded['profile_img_path'] = Image::IMAGE_DIRECTORY . $fullsized;
            // update image
            $this->userModel->update4(
                ['profile_img_path', 'thumbnail_img_path'],
                [Image::IMAGE_DIRECTORY . $fullsized, Image::IMAGE_THUMBNAIL_DIRECTORY . $thumb],
                ['id'],
                [$user->id]
            );

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }

    public function licenseInfo()
    {
        $fieldOfPracticeOptions = [
            'General Practice',
            'Endodontics',
            'Prosthodontics',
            'Orthodontics',
            'Oral and maxillofacial surgery',
            'Pedodontics',
            'Periodontics'
        ];
        $typeOfPracticeOptions = [
            'Government Dentist',
            'Clinic Owner',
            'Dental Associate',
            'School Dentist',
            'None Practicing'
        ];

        $user = $this->session->auth(false);

        $data = [
            'current_route' => __FUNCTION__,
            'field_practice_options' => $fieldOfPracticeOptions,
            'type_practice_options' => $typeOfPracticeOptions,

            'prc_number' => $user->prc_number,
            'prc_registration_date' => $user->prc_registration_date,
            'prc_expiration_date' => $user->prc_expiration_date,
            'field_practice' => $user->field_practice,
            'type_practice' => $user->type_practice,

            'prc_number_err' => '',
            'prc_registration_date_err' => '',
            'prc_expiration_date_err' => '',
            'field_practice_err' => '',
            'type_practice_err' => '',
        ];

        $this->view('profiles/licenseInfo', $data);
    }
    public function updateLicense()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType !== "application/json") {
                throw new Error('Your content type must be in \'application/json\'');
            }

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $decoded['message'] = 'License info was successfully updated!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            // check inputs
            if (empty($decoded['license']['prc_number'])) {
                $decoded['errors']['prc_number_err'] = 'Please enter your prc_number';
            }
            if (empty($decoded['license']['prc_registration_date'])) {
                $decoded['errors']['prc_registration_date_err'] = 'Please enter your prc_registration_date';
            }
            if (empty($decoded['license']['prc_expiration_date'])) {
                $decoded['errors']['prc_expiration_date_err'] = 'Please enter your prc_expiration_date';
            }
            if (empty($decoded['license']['field_practice'])) {
                $decoded['errors']['field_practice_err'] = 'Please enter your your field_practice';
            }
            if (empty($decoded['license']['type_practice'])) {
                $decoded['errors']['type_practice_err'] = 'Please select your type_practice';
            }

            if (sizeof($decoded['errors']) > 0) {
                throw new Error('You have some input errors. Please check your inputs');
            }

            // check if payment insert is unsuccessful or prc number does not exist
            if (!$this->profileModel->update3(
                [
                    'prc_number',
                    'prc_registration_date',
                    'prc_expiration_date',
                    'field_practice',
                    'type_practice'
                ],
                [
                    $decoded['license']['prc_number'],
                    $decoded['license']['prc_registration_date'],
                    $decoded['license']['prc_expiration_date'],
                    $decoded['license']['field_practice'],
                    $decoded['license']['type_practice']
                ],
                ['id'],
                [$this->session->auth()->profile_id]
            )) {
                throw new Error('Something went wrong with the updating of the email. Try again');
            }

            $this->duesModel->update(
                [
                    'prc_number'
                ],
                [
                    $decoded['license']['prc_number'],
                ],
                ['profile_id'],
                [$this->session->auth()->profile_id]
            );

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }

    public function personalInfo()
    {
        $genderOptions = [
            'Male',
            'Female'
        ];

        $user = $this->session->auth(false);

        $data = [
            'current_route' => __FUNCTION__,
            'gender_options' => $genderOptions,

            'first_name' => $user->first_name ?? '',
            'middle_name' => $user->middle_name ?? '',
            'last_name' => $user->last_name ?? '',
            'birthdate' => $user->birthdate ?? '',
            'gender' => $user->gender ?? '',
            'contact_number' => $user->contact_number ?? '',
            'fb_account_name' => $user->fb_account_name ?? '',
            'address' => $user->address ?? '',

            'first_name_err' => '',
            'middle_name_err' => '',
            'last_name_err' => '',
            'gender_err' => '',
            'fb_account_name_err' => '',
            'contact_number_err' => '',
            'birthdate_err' => '',
            'address_err' => '',
        ];

        $this->view('profiles/personalInfo', $data);
    }
    public function updatePersonal()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType !== "application/json") {
                throw new Error('Your content type must be in \'application/json\'');
            }

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $decoded['message'] = 'Personal info was successfully updated!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            // check inputs
            if (empty($decoded['personal']['first_name'])) {
                $decoded['errors']['first_name_err'] = 'Please enter your firstname';
            }
            if (empty($decoded['personal']['middle_name'])) {
                $decoded['errors']['middle_name_err'] = 'Please enter your middlename';
            }
            if (empty($decoded['personal']['last_name'])) {
                $decoded['errors']['last_name_err'] = 'Please enter your lastname';
            }
            if (empty($decoded['personal']['birthdate'])) {
                $decoded['errors']['birthdate_err'] = 'Please enter your your birthdate';
            }
            if (empty($decoded['personal']['gender'])) {
                $decoded['errors']['gender_err'] = 'Please select your gender';
            }
            if (empty($decoded['personal']['contact_number'])) {
                $decoded['errors']['contact_number_err'] = 'Please enter your contact number';
            }
            if (empty($decoded['personal']['fb_account_name'])) {
                $decoded['errors']['fb_account_name_err'] = 'Please enter your fb account name';
            }
            if (empty($decoded['personal']['address'])) {
                $decoded['errors']['address_err'] = 'Please enter your home address';
            }

            if (sizeof($decoded['errors']) > 0) {
                throw new Error('You have some input errors. Please check your inputs');
            }

            // check if payment insert is unsuccessful or prc number does not exist
            if (!$this->profileModel->update3(
                [
                    'first_name',
                    'middle_name',
                    'last_name',
                    'birthdate',
                    'gender',
                    'contact_number',
                    'fb_account_name',
                    'address',
                ],
                [
                    $decoded['personal']['first_name'],
                    $decoded['personal']['middle_name'],
                    $decoded['personal']['last_name'],
                    $decoded['personal']['birthdate'],
                    $decoded['personal']['gender'],
                    $decoded['personal']['contact_number'],
                    $decoded['personal']['fb_account_name'],
                    $decoded['personal']['address']
                ],
                ['id'],
                [$this->session->auth()->profile_id]
            )) {
                throw new Error('Something went wrong with the updating of the email. Try again');
            }

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }

    public function clinicInfo()
    {
        $user = $this->session->auth(false);

        $data = [
            'current_route' => __FUNCTION__,

            'clinic_name' => $user->clinic_name ?? '',
            'clinic_street' =>  $user->clinic_street ?? '',
            'clinic_district' =>  $user->clinic_district ?? '',
            'clinic_city' =>  $user->clinic_city ?? '',
            'clinic_contact_number' =>  $user->clinic_contact ?? '',

            'clinic_name_err' => '',
            'clinic_street_err' => '',
            'clinic_district_err' => '',
            'clinic_city_err' => '',
            'clinic_contact_number_err' => '',
        ];

        $this->view('profiles/clinicInfo', $data);
    }
    public function updateClinic()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType !== "application/json") {
                throw new Error('Your content type must be in \'application/json\'');
            }

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $decoded['message'] = 'Clinic info was successfully updated!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            // check inputs
            if (empty($decoded['clinic']['clinic_name'])) {
                $decoded['errors']['clinic_name_err'] = 'Please enter your clinic_name';
            }
            if (empty($decoded['clinic']['clinic_street'])) {
                $decoded['errors']['clinic_street_err'] = 'Please enter your clinic_street';
            }
            if (empty($decoded['clinic']['clinic_district'])) {
                $decoded['errors']['clinic_district_err'] = 'Please enter your clinic_district';
            }
            if (empty($decoded['clinic']['clinic_city'])) {
                $decoded['errors']['clinic_city_err'] = 'Please enter your your clinic_city';
            }
            if (empty($decoded['clinic']['clinic_contact_number'])) {
                $decoded['errors']['clinic_contact_number_err'] = 'Please select your clinic_contact_number';
            }

            if (sizeof($decoded['errors']) > 0) {
                throw new Error('You have some input errors. Please check your inputs');
            }

            // check if payment insert is unsuccessful or prc number does not exist
            if (!$this->profileModel->update3(
                [
                    'clinic_name',
                    'clinic_street',
                    'clinic_district',
                    'clinic_city',
                    'clinic_contact'
                ],
                [
                    $decoded['clinic']['clinic_name'],
                    $decoded['clinic']['clinic_street'],
                    $decoded['clinic']['clinic_district'],
                    $decoded['clinic']['clinic_city'],
                    $decoded['clinic']['clinic_contact_number']
                ],
                ['id'],
                [$this->session->auth()->profile_id]
            )) {
                throw new Error('Something went wrong with the updating of the email. Try again');
            }

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }

    public function emergencyInfo()
    {
        $user = $this->session->auth(false);

        $data = [
            'current_route' => __FUNCTION__,

            'emergency_person_name' => $user->emergency_person_name ?? '',
            'emergency_address' =>  $user->emergency_address ?? '',
            'emergency_contact_number' =>  $user->emergency_contact_number ?? '',

            'emergency_person_name_err' => '',
            'emergency_address_err' => '',
            'emergency_contact_number_err' => ''
        ];

        $this->view('profiles/emergencyInfo', $data);
    }
    public function updateEmergency()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

            if ($contentType !== "application/json") {
                throw new Error('Your content type must be in \'application/json\'');
            }

            $content = trim(file_get_contents("php://input"));
            $decoded = json_decode($content, true);

            $decoded['message'] = 'Emergency info was successfully updated!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            // check inputs
            if (empty($decoded['emergency']['emergency_person_name'])) {
                $decoded['errors']['emergency_person_name_err'] = 'Please enter your emergency_person_name';
            }
            if (empty($decoded['emergency']['emergency_address'])) {
                $decoded['errors']['emergency_address_err'] = 'Please enter your emergency_address';
            }
            if (empty($decoded['emergency']['emergency_contact_number'])) {
                $decoded['errors']['emergency_contact_number_err'] = 'Please enter your emergency_contact_number';
            }

            if (sizeof($decoded['errors']) > 0) {
                throw new Error('You have some input errors. Please check your inputs');
            }

            // check if payment insert is unsuccessful or prc number does not exist
            if (!$this->profileModel->update3(
                [
                    'emergency_person_name',
                    'emergency_address',
                    'emergency_contact_number'
                ],
                [
                    $decoded['emergency']['emergency_person_name'],
                    $decoded['emergency']['emergency_address'],
                    $decoded['emergency']['emergency_contact_number'],
                ],
                ['id'],
                [$this->session->auth()->profile_id]
            )) {
                throw new Error('Something went wrong with the updating of the email. Try again');
            }

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }

    public function fetchUserProfile()
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                throw new Error('Your request method must be in \'POST\'');
            }

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $decoded['message'] = 'User profile was successfully fetched!';
            $decoded['status'] = 'ok';
            $decoded['errors'] = [];

            $decoded['data'] = $this->profileModel->getProfileUser(
                ['*', 'profiles.id AS id']
            );

            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        } catch (\Throwable $th) {
            header("Content-Type: application/json; charset=UTF-8");
            $decoded['status'] = 'fail';
            $decoded['message'] = $th->getMessage();
            $reply = json_encode($decoded);

            header("Content-Type: application/json; charset=UTF-8");
            exit($reply);
        }
    }
}
