<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Profiles extends Controller
{
    public function __construct()
    {
        redirectIfNotAuthUser();
        redirectNotFullyRegisteredUser();
        redirectInactiveUserOrRegenerateTimer();

        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $data = [
            'current_route' => __FUNCTION__,
        ];

        // $this->view('users/index', $data);
        unset($_SESSION['login_success']);
        redirect('profiles/userInfo');
    }
    public function userInfo()
    {
        $user = $this->userModel->getUserById($_SESSION['user_id']);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'current_route' => __FUNCTION__,
                'user_id' => $_SESSION['user_id'] ?? '',

                'has_facebook_auth' => !empty($user->fb_user_id) ? true : false,
                'has_google_auth' => !empty($user->google_user_id) ? true : false,
                'has_password' => !empty($user->password) ? true : false,
                'has_email' => !empty($user->email) ? true : false,

                'email' => $user->email ?? '',
                'old_password' => trim($_POST['old_password']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),

                'old_password_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $verifiedUser = $this->userModel->getVerifiedUserByEmail($_SESSION['user_email']);
            $hashed_password = $verifiedUser->password;
            if (empty($data['old_password'])) {
                $data['old_password_err'] = 'Please enter password';
            } else {
                if (!password_verify($data['old_password'], $hashed_password)) {
                    $data['old_password_err'] = 'Old Password incorrect';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            } elseif (strlen($data['password']) < 6) {
                $data['password_err'] = 'Password must be at least 6 characters';
            }
            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            // Check if all errors are empty
            if (
                empty($data['old_password_err']) &&
                empty($data['password_err']) &&
                empty($data['confirm_password_err'])
            ) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                if (!$this->userModel->update($data)) {
                    die('Something went wrong');
                }

                // flash('update_status', 'Your password is succesfully updated!');
                redirect('profiles/userInfo');
            } else {
                // Load view with errors
                $this->view('profiles/userInfo', $data);
            }
        } else {
            $data = [
                'current_route' => __FUNCTION__,

                'has_facebook_auth' => !empty($user->fb_user_id) ? true : false,
                'has_google_auth' => !empty($user->google_user_id) ? true : false,
                'has_password' => !empty($user->password) ? true : false,
                'has_email' => !empty($user->email) ? true : false,


                'email' => $user->email,
                'old_password' => '',
                'password' => '',
                'confirm_password' => '',

                'old_password_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            $this->view('profiles/userInfo', $data);
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

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $user = $this->userModel->getUserById($_SESSION['user_id']);

            $data = [
                'current_route' => __FUNCTION__,
                'user_id' => $_SESSION['user_id'] ?? '',
                'field_practice_options' => $fieldOfPracticeOptions,
                'type_practice_options' => $typeOfPracticeOptions,

                'prc_number' => trim($_POST['prc_number']),
                'prc_registration_date' => trim($_POST['prc_registration_date']),
                'prc_expiration_date' => trim($_POST['prc_expiration_date']),
                'field_practice' => trim($_POST['field_practice']),
                'type_practice' => trim($_POST['type_practice']),

                'prc_number_err' => '',
                'prc_registration_date_err' => '',
                'prc_expiration_date_err' => '',
                'field_practice_err' => '',
                'type_practice_err' => '',
            ];

            // Validate prc info
            if (empty($data['prc_number'])) {
                $data['prc_number_err'] = 'Please enter your prc number';
            }
            if (empty($data['prc_registration_date'])) {
                $data['prc_registration_date_err'] = 'Please enter your prc registration date';
            }
            if (empty($data['prc_expiration_date'])) {
                $data['prc_expiration_date_err'] = 'Please enter your prc expiration date';
            }
            if (empty($data['field_practice'])) {
                $data['field_practice_err'] = 'Please select your field of practice';
            }
            if (empty($data['type_practice'])) {
                $data['type_practice_err'] = 'Please select your type of practice';
            }

            // Check if errors are empty
            if (empty($data['prc_number_err']) && empty($data['prc_registration_date_err']) && empty($data['prc_expiration_date_err']) && empty($data['field_practice_err']) && empty($data['type_practice_err'])) {
                if ($this->userModel->updatePrcInfo($data)) {
                    flash('update_success', 'Your license profile was updated');
                    redirect('profiles/licenseInfo');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('profiles/licenseInfo', $data);
            }
        } else {
            $user = $this->userModel->getUserById($_SESSION['user_id']);

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
    }
    public function personalInfo()
    {
        $genderOptions = [
            'Male',
            'Female'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $user = $this->userModel->getUserById($_SESSION['user_id']);

            $data = [
                'current_route' => __FUNCTION__,
                'user_id' => $_SESSION['user_id'] ?? '',
                'gender_options' => $genderOptions,

                'first_name' => trim($_POST['first_name']),
                'middle_name' => trim($_POST['middle_name']),
                'last_name' => trim($_POST['last_name']),
                'birthdate' => trim($_POST['birthdate']),
                'gender' => trim($_POST['gender']),
                'contact_number' => trim($_POST['contact_number']),
                'fb_account_name' => trim($_POST['fb_account_name']),
                'email' => trim($_POST['email']),
                'address' => trim($_POST['address']),

                'first_name_err' => '',
                'middle_name_err' => '',
                'last_name_err' => '',
                'gender_err' => '',
                'fb_account_name_err' => '',
                'email_err' => '',
                'contact_number_err' => '',
                'birthdate_err' => '',
                'address_err' => '',
            ];

            // Validate Personal info
            if (empty($data['first_name'])) {
                $data['first_name_err'] = 'Please enter your firstname';
            }
            if (empty($data['middle_name'])) {
                $data['middle_name_err'] = 'Please enter your middlename';
            }
            if (empty($data['last_name'])) {
                $data['last_name_err'] = 'Please enter your lastname';
            }
            if (empty($data['birthdate'])) {
                $data['birthdate_err'] = 'Please enter your your birthdate';
            }
            if (empty($data['gender'])) {
                $data['gender_err'] = 'Please select your gender';
            }
            if (empty($data['contact_number'])) {
                $data['contact_number_err'] = 'Please enter your contact number';
            }
            if (empty($data['fb_account_name'])) {
                $data['fb_account_name_err'] = 'Please enter your fb account name';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter your email';
            } else {
                if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                    $data['email_err'] = 'Please enter your email';
                }
            }
            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter your home address';
            }

            if (
                empty($data['first_name_err']) && empty($data['middle_name_err'])
                && empty($data['last_name_err']) && empty($data['birthdate_err'])
                && empty($data['gender_err']) && empty($data['contact_number_err'])
                && empty($data['fb_account_name_err']) && empty($data['email_err'])
                && empty($data['address_err'])
            ) {

                if ($this->userModel->updatePersonalInfo($data)) {
                    flash('update_success', 'Your personal profile was updated');
                    redirect('profiles/personalInfo');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('profiles/personalInfo', $data);
            }
        } else {
            $user = $this->userModel->getUserById($_SESSION['user_id']);

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
                'email' => $user->email ?? '',
                'address' => $user->address ?? '',

                'first_name_err' => '',
                'middle_name_err' => '',
                'last_name_err' => '',
                'gender_err' => '',
                'fb_account_name_err' => '',
                'email_err' => '',
                'contact_number_err' => '',
                'birthdate_err' => '',
                'address_err' => '',
            ];

            $this->view('profiles/personalInfo', $data);
        }
    }
    public function clinicInfo()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'current_route' => __FUNCTION__,
                'user_id' => $_SESSION['user_id'] ?? '',

                'clinic_name' => trim($_POST['clinic_name']),
                'clinic_street' => trim($_POST['clinic_street']),
                'clinic_district' => trim($_POST['clinic_district']),
                'clinic_city' => trim($_POST['clinic_city']),
                'clinic_contact_number' => trim($_POST['clinic_contact_number']),

                'clinic_name_err' => '',
                'clinic_street_err' => '',
                'clinic_district_err' => '',
                'clinic_city_err' => '',
                'clinic_contact_number_err' => '',
            ];

            // Validate clinic info
            if (empty($data['clinic_name'])) {
                $data['clinic_name_err'] = 'Please enter your clinic name';
            }
            if (empty($data['clinic_street'])) {
                $data['clinic_street_err'] = 'Please enter your clinic street';
            }
            if (empty($data['clinic_district'])) {
                $data['clinic_district_err'] = 'Please enter your clinic district';
            }
            if (empty($data['clinic_city'])) {
                $data['clinic_city_err'] = 'Please enter your clinic city';
            }
            if (empty($data['clinic_contact_number'])) {
                $data['clinic_contact_number_err'] = 'Please enter your clinic contact number';
            }

            // Check if errors are empty
            if (
                empty($data['clinic_name_err']) && empty($data['clinic_street_err'])
                && empty($data['clinic_district_err']) && empty($data['clinic_city_err'])
                && empty($data['clinic_contact_number_err'])
            ) {

                if ($this->model('Clinic')->updateOrInsert($data)) {
                    flash('update_success', 'Your clinic information was updated');
                    redirect('profiles/clinicInfo');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('profiles/clinicInfo', $data);
            }
        } else {
            $clinic = $this->model('Clinic')->getClinicById($_SESSION['user_id']);

            $data = [
                'current_route' => __FUNCTION__,

                'clinic_name' => $clinic->name ?? '',
                'clinic_street' =>  $clinic->street ?? '',
                'clinic_district' =>  $clinic->district ?? '',
                'clinic_city' =>  $clinic->city ?? '',
                'clinic_contact_number' =>  $clinic->contact_number ?? '',

                'clinic_name_err' => '',
                'clinic_street_err' => '',
                'clinic_district_err' => '',
                'clinic_city_err' => '',
                'clinic_contact_number_err' => '',
            ];

            $this->view('profiles/clinicInfo', $data);
        }
    }

    public function __destruct()
    {
        unset($_SESSION['fb_account_taken']);
        unset($_SESSION['google_account_taken']);
    }
}
