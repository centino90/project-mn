<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    $this->activityModel = $this->model('Activity');
    $this->profileModel = $this->model('Profile');

    parent::__construct();
  }

  public function index()
  {
    $this->url->redirectToLoginpage();
  }

  /* ALL ACCESSIBLE ENDPOINTS */
  public function fetchUserProfile()
  {
    try {
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Error('Your request method must be in \'POST\'');
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $decoded['message'] = 'User profiles were successfully fetched!';
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

  public function redirectPage(): void
  {
    //Check Facebook API request code
    if (isset($_GET['state']) && FB_APP_STATE == $_GET['state']) {
      // try and log the user in with $_GET vars from facebook 
      $fb = tryAndLoginWithFacebook($_GET, $this);

      if ($fb['status'] == 'fail') {
        if ($fb['reason'] == 'unverifiedEmail') {
          $this->view('users/redirectPage', $fb);
        } else {
          $this->view('users/redirectPage', $fb);
        }
      } else if ($fb['status'] == 'ok') {
        if ($fb['user']) {
          $this->createUserSession($fb['user']);
        } else if ($fb['added']) {
          $this->view('users/redirectPage', $fb);
        }
      }
    }

    //Check Google API request code
    if (isset($_GET['code'])) {
      // try and log the user in with $_GET code from google 
      $gg = tryAndLoginWithGoogle($_GET, $this);

      if ($gg['status'] == 'fail') {
        if ($gg['reason'] == 'unverifiedEmail') {
          $this->view('users/redirectPage', $gg);
        } else {
          $this->view('users/redirectPage', $gg);
        }
      } else if ($gg['status'] == 'ok') {
        if ($gg['user']) {
          $this->createUserSession($gg['user']);
        } else if ($gg['added']) {
          $this->view('users/redirectPage', $gg);
        }
      }
    }
  }

  /* 
    *Accepts both post and get requests*
    post: form-based password reset request
    get: link-based password reset request (for rerequest or resend usecase)

    Resets password and return its unencrypted value
    and send it to the requestor's email
  */
  public function handlePasswordResetRequest($data = null)
  {
    // $unverifiedUser = $this->userModel->getRowByColumn($data['id_type'], $data['id']);
    $unverifiedUser = $this->userModel->find(
      ['*'],
      [$data['id_type']],
      [$data['id']]
    );

    if ($unverifiedUser) {
      $mail = new PHPMailer(true);

      try {
        //Server settings               
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->Port       = MAIL_PORT;
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom(MAIL_FROM_ADDRESS, 'Office of the Philippine Dental Association Davao City Chapter');
        $mail->addAddress($data['receiver_email'], 'PDA-DCC Member');

        //Content
        $email_template = APPROOT . '/views/inc/templateVerifyEmail.php';
        $verify_url = URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->forgot_password_vkey;
        $about_url = URLROOT . '/about';
        $privacy_url = URLROOT . '/about/privacy';
        $terms_url = URLROOT . '/about/terms';
        $subject = 'PDA-DCC ' . str_replace('_', ' ', $data['email_confirmation_type']) . ' VERIFICATION';
        $logo_url = URLROOT . '/img/PDA-DCC.jpg';
        $emailTo = $data['receiver_email'];
        $timestamp = date('Y-m-d H:i:s');
        $transaction = str_replace('_', ' ', strtolower($data['email_confirmation_type']));
        $current_year = date('Y');

        $message = file_get_contents($email_template);
        $message = str_replace('{{verify_url}}', $verify_url, $message);
        $message = str_replace('{{about_url}}', $about_url, $message);
        $message = str_replace('{{privacy_url}}', $privacy_url, $message);
        $message = str_replace('{{terms_url}}', $terms_url, $message);
        $message = str_replace('{{logo_url}}', $logo_url, $message);
        $message = str_replace('{{email_to}}', $emailTo, $message);
        $message = str_replace('{{transaction}}', $transaction, $message);
        $message = str_replace('{{timestamp}}', $timestamp, $message);
        $message = str_replace('{{current_year}}', $current_year, $message);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
        $this->view('users/redirectPage', $data = ['message' => 'A confirmation link was just sent to ' . $data['receiver_email'] . '. The changes will take effect after you have clicked the link.', 'email' => $data['receiver_email']]);
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }

  public function handleEmailConfirmation()
  {
    if (isset($_GET['type'])) {
      $confirmationType = $_GET['type'];

      if ($confirmationType == 'ACCOUNT_REGISTRATION') {
        if (isset($_GET['id']) && isset($_GET['vkey'])) {
          $userId = $_GET['id'];
          $accountRegistrationVkey = $_GET['vkey'];

          $user = $this->userModel->find(
            ['*'],
            ['id', 'account_registration_vkey'],
            [$userId, $accountRegistrationVkey]
          );

          if ($user) {
            $this->userModel->update4(
              ['email_verified'],
              [true],
              ['id'],
              [$user->id]
            );

            $verifiedUser = $this->userModel->find(
              ['*'],
              ['id', 'email_verified'],
              [$userId, true]
            );
            if ($verifiedUser) {
              $this->userModel->regenerateVkey('account_registration_vkey', 'email', $verifiedUser->email);
              $this->createUserSession($verifiedUser);
            }
          } else {
            // id or vkey is not correct
            $this->view('users/redirectPage', ['message' => 'These verification credentials are not correct.']);
          }
        }
      } elseif ($confirmationType == 'CHANGE_EMAIL') {
        if (isset($_GET['id']) && isset($_GET['vkey']) && isset($_GET['newEmail'])) {
          $userId = $_GET['id'];
          $newEmail = $_GET['newEmail'];
          $changeEmailVkey = $_GET['vkey'];

          $user = $this->userModel->find(
            ['*'],
            ['id', 'change_email_vkey'],
            [$userId, $changeEmailVkey]
          );

          if ($user) {
            if ($user->email_verified && !$user->changing_email) {
              $this->view('users/redirectPage', ['message' => 'This verification key is already used or replaced.']);
              return;
            } else if ($user->email_verified && $user->changing_email) {
              if ($newEmail != $user->new_email) {
                $this->view('users/redirectPage', ['message' => 'These credentials are not correct. Try again.']);
                return;
              }

              $this->userModel->update4(
                ['email', 'new_email', 'changing_email'],
                [$user->new_email, null, false],
                ['id'],
                [$user->id]
              );

              $this->view('users/redirectPage', ['message' => 'Your email was successfully changed. Sign in again.']);

              $this->session->clear();
            } else {
              $this->view('users/redirectPage', ['message' => 'Email not verified']);
            }
          } else {
            $this->view('users/redirectPage', $data = ['message' => 'These verification credentials are not correct.']);
          }
        }
      } elseif ($confirmationType == 'FORGOT_PASSWORD') {
        if (isset($_GET['id']) && isset($_GET['vkey'])) {
          $userId = $_GET['id'];
          $forgotPasswordVkey = $_GET['vkey'];

          $user = $this->userModel->find(
            ['*'],
            ['id', 'forgot_password_vkey'],
            [$userId, $forgotPasswordVkey]
          );

          if ($user) {
            if (empty($user->new_password)) {
              $this->view('users/redirectPage', ['message' => 'This verification key is already used or replaced.']);
              return;
            }
            $newPassword = $this->userModel->resetPasswordAndReturnUnencryptedVersion($user->id);

            $this->userModel->update4(
              ['new_password'],
              [null],
              ['id'],
              [$user->id]
            );
            $this->view('users/redirectPage', ['message' => 'Your password was successfully resetted. Here is your new password: <b>' . $newPassword . '</b>', 'reason' => 'passwordReset', 'email' => $user->email]);
            $this->session->clear();
          } else {
            $this->view('users/redirectPage', ['message' => 'These verification credentials are not correct.']);
          }
        }
      }
    }

    $this->view('users/redirectPage', ['message' => 'Invalid credentials. Try again']);
  }

  public function handleUserRegistration($data = null)
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($data)) {
      if (isset($_POST['vkeyType']) && isset($_POST['id_type']) && isset($_POST['id'])) {
        $data = $_POST;
        $vkey = $this->userModel->regenerateVkey($data['vkeyType'], $data['id_type'], $data['id']);
        $data['vkey'] = $vkey;
      }
    }

    $vkeyType = $data['vkeyType'];

    // $unverifiedUser = $this->userModel->getRowByColumn($data['id_type'], $data['id']);
    $unverifiedUser = $this->userModel->find(
      ['*'],
      [$data['id_type']],
      [$data['id']]
    );

    if ($unverifiedUser) {
      $mail = new PHPMailer(true);

      try {
        //Server settings             
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->Port       = MAIL_PORT;
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom(MAIL_FROM_ADDRESS, 'Office of the Philippine Dental Association Davao City Chapter');
        $mail->addAddress($data['receiver_email'], 'PDA-DCC Member');

        //Content
        $email_template = APPROOT . '/views/inc/templateVerifyEmail.php';
        $logo_url = URLROOT . '/img/PDA-DCC.jpg';
        $verify_url = URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->$vkeyType;
        $about_url = URLROOT . '/about';
        $privacy_url = URLROOT . '/about/privacy';
        $terms_url = URLROOT . '/about/terms';
        $subject = 'PDA-DCC ' . str_replace('_', ' ', $data['email_confirmation_type']) . ' VERIFICATION';
        $emailTo = $data['receiver_email'];
        $timestamp = date('Y-m-d H:i:s');
        $transaction = str_replace('_', ' ', strtolower($data['email_confirmation_type']));
        $current_year = date('Y');
        $current_email = $data['id'];

        $message = file_get_contents($email_template);
        $message = str_replace('{{logo_url}}', $logo_url, $message);
        $message = str_replace('{{verify_url}}', $verify_url, $message);
        $message = str_replace('{{about_url}}', $about_url, $message);
        $message = str_replace('{{privacy_url}}', $privacy_url, $message);
        $message = str_replace('{{terms_url}}', $terms_url, $message);
        $message = str_replace('{{email_to}}', $emailTo, $message);
        $message = str_replace('{{transaction}}', $transaction, $message);
        $message = str_replace('{{timestamp}}', $timestamp, $message);
        $message = str_replace('{{current_year}}', $current_year, $message);
        $message = str_replace('{{current_email}}', $current_email, $message);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();

        if (isset($data['logoutAfter']) && $data['logoutAfter']) {
          $this->session->clear();
        }

        $this->view('users/redirectPage', $data = ['message' => 'A confirmation link was just sent to ' . $data['receiver_email'] . '. The changes will take effect after you have clicked the link.', 'email' => $data['receiver_email']]);
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }

  public function abortRegistration()
  {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),

        'email_err' => ''
      ];

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter your email';
        }
      }

      // Check if all errors are empty
      if (
        empty($data['email_err'])
      ) {
        if (!$this->userModel->deletePermanent(['email'], [$data['email']])) {
          $this->view('users/redirectPage', $data = ['message' => 'Oooops. Something went wrong. Try again.']);
        }

        // show abort message
        $this->view('users/redirectPage', ['message' => 'Your registration was successfully cancelled. Your email is now again open for registration.']);
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    } else {
      $this->view('users/redirectPage', ['message' => 'GET request is prohibited. Try again.']);
    }
  }

  /* 
    confirm if email exist and then send 
    pword and email to pword reset handler
  */
  public function forgotPassword()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'g_recaptcha_response' => trim($_POST['g-recaptcha-response']),

        'email_err' => '',
        'g_recaptcha_response_err' => ''
      ];

      // Validate recaptcha
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRET . '&response=' . $data['g_recaptcha_response']);
      $responseData = json_decode($verifyResponse);
      if (!$responseData->success) {
        $data['g_recaptcha_response_err'] = 'Please check the recaptcha';
      }

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter a valid email format';
        }

        if (!$this->userModel->find(['*'], ['email'], [$data['email']])) {
          $data['email_err'] = 'Email not found';
        }
      }

      // Check if all errors are empty
      if (empty($data['email_err']) && empty($data['g_recaptcha_response_err'])) {
        // if (!$this->userModel->storeNewPassword($data['email'])) {
        //   $this->view('users/redirectPage', $data = ['message' => 'New password was not stored. Try again']);
        //   return;
        // }

        $this->userModel->update4(
          ['new_password'],
          [password_hash(uniqid(), PASSWORD_DEFAULT)],
          ['email'],
          [$data['email']]
        );

        $this->handlePasswordResetRequest(
          [
            'email_confirmation_type' => 'FORGOT_PASSWORD',
            'id_type' => 'email',
            'id' => $data['email'],
            'receiver_email' => $data['email'],
            'vkey' => $this->userModel->regenerateVkey('forgot_password_vkey', 'email', $data['email']),
            'vkeyType' => 'forgot_password_vkey',
          ]
        );
      } else {
        // Load view with errors
        $this->view('users/forgotPassword', $data);
      }
    } else {

      $data = [
        'email' => '',
        'g_recaptcha_response' => '',

        'email_err' => '',
        'g_recaptcha_response_err' => ''
      ];

      $this->view('users/forgotPassword', $data);
    }
  }

  /* GUEST ACCESSIBLE ENDPOINTS */
  public function login(): void
  {
    if ($this->isLoggedin() && $this->isEmailVerified()) {
      $this->url->redirectToHomepage();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // Init data
      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'email_err' => '',
        'password_err' => '',
      ];

      // Validate email
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter email';
      }

      // Validate Password
      if (empty($data['password'])) {
        $data['password_err'] = 'Please enter password';
      }

      // Make sure errors are empty
      if (empty($data['email_err']) && empty($data['password_err'])) {

        // Check and set logged in user
        // $requestedUser = $this->userModel->getRowByColumn('email', $data['email']);
        $requestedUser = $this->userModel->find(['*'], ['email'], [$data['email']]);
        if ($requestedUser) {
          // if inputted email exist in db
          $hashed_password = $requestedUser->password;
          if (password_verify($data['password'], $hashed_password)) {
            if (!$requestedUser->email_verified) {
              // if requested user is not yet verified (email)
              $emailConfirmation =  [
                'email_confirmation_type' => 'ACCOUNT_REGISTRATION',
                'id_type' => 'email',
                'id' => $data['email'],
                'receiver_email' => $data['email'],
                'vkeyType' => 'account_registration_vkey',
                'reason' => 'unverifiedEmail',
                'route' => __FUNCTION__,
                'message' => $data['email'] . ' is not yet verified. Verify first to enable your account.',
                'cancellable' => true
              ];

              $this->view('users/redirectPage', $emailConfirmation);
              return;
            }
            // login user
            $this->createUserSession($requestedUser);
          } else {
            // if password do not match
            $data['password_err'] = 'Email or password is not correct';
            $this->view('users/login', $data);
          }
        } else {
          // if inputted email does not exist in db
          $data['password_err'] = 'Email or password is not correct';
          $this->view('users/login', $data);
        }
      } else {
        // Load view with errors
        $this->view('users/login', $data);
      }
    } else {
      // Init data
      $data = [
        'email' => '',
        'password' => '',
        'email_err' => '',
        'password_err' => '',
      ];

      // Load view
      $this->view('users/login', $data);
    }
  }

  /* 
    creates user based on email and pword inputs
    and passes the newly created user to handleUserRegistration()
    with a confirmation type of 'register'
  */
  public function register()
  {
    if ($this->isLoggedin() && $this->isEmailVerified()) {
      $this->url->redirectToHomepage();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),
        'g_recaptcha_response' => trim($_POST['g-recaptcha-response']),
        'is_admin' => false,


        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
        'g_recaptcha_response_err' => ''
      ];

      // Validate recaptcha
      $verifyResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . RECAPTCHA_SECRET . '&response=' . $data['g_recaptcha_response']);
      $responseData = json_decode($verifyResponse);
      if (!$responseData->success) {
        $data['g_recaptcha_response_err'] = 'Please check the recaptcha';
      }

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter your email';
        }

        if ($this->userModel->find(['*'], ['email'], [$data['email']])) {
          $data['email_err'] = 'Email is already taken';
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
        empty($data['email_err']) && empty($data['password_err'])
        && empty($data['confirm_password_err']) && empty($data['g_recaptcha_response_err'])
      ) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        // if (!$this->userModel->register($data)) {
        //   $this->view('users/redirectPage', $data = ['message' => 'Oooops. Something went wrong. Try again.']);
        // }

        $this->userModel->store2(
          ['email', 'password', 'email_vkey'],
          [$data['email'], $data['password'], uniqid()]
        );

        // initialize data to pass as params for email sending
        $this->handleUserRegistration(
          [
            'email_confirmation_type' => 'ACCOUNT_REGISTRATION',
            'id_type' => 'email',
            'id' => $data['email'],
            'receiver_email' => $data['email'],
            'vkey' => $this->userModel->regenerateVkey('account_registration_vkey', 'email', $data['email']),
            'vkeyType' => 'account_registration_vkey'
          ]
        );
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    } else {

      $data = [
        'email' => '',
        'password' => '',
        'confirm_password' => '',
        'g_recaptcha_response' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
        'g_recaptcha_response_err' => ''
      ];

      $this->view('users/register', $data);
    }
  }

  /* AUTH ACCESSIBLE ENDPOINTS */
  /* 
    *triggered when user sign in using 3rd party auths*

    Prompts user to register email and password to a newly created user
    and then redirects to the *steps*
  */
  public function registerEmailPassword()
  {
    $this->session->start();

    if (!$this->isLoggedin()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isPasswordRegistered()) {
      $this->url->redirectToHomepage();
    }

    if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
      $this->url->redirectToHomepage();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter your email';
        }

        if ($this->userModel->find(['*'], ['email'], [$data['email']])) {
          $data['email_err'] = 'Email is already taken';
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
        empty($data['email_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])
      ) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if (!$this->userModel->updateRowsById(['email', 'password'], [$data['email'], $data['password']], $this->session->auth()->id)) {
          $data['password_err'] = 'Something went wrong';
          $this->view('users/registerEmailPassword', $data);
          return;
        }

        $this->handleUserRegistration(
          [
            'email_confirmation_type' => 'ACCOUNT_REGISTRATION',
            'id_type' => 'email',
            'id' => $data['email'],
            'receiver_email' => $data['email'],
            'vkey' => $this->userModel->regenerateVkey('account_registration_vkey', 'email', $data['email']),
            'vkeyType' => 'account_registration_vkey',
            'logoutAfter' => true
          ]
        );
      } else {
        // Load view with errors
        $this->view('users/registerEmailPassword', $data);
      }
    } else {

      $data = [
        'email' => '',
        'password' => '',
        'confirm_password' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => ''
      ];

      $this->view('users/registerEmailPassword', $data);
    }
  }

  public function searchProfileBeforeRegister()
  {
    try {
      $this->session->start();
      if (!$this->isLoggedin() || !$this->isPasswordRegistered()) {
        $this->url->redirectToLoginpage();
      }

      if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
        $this->url->redirectToHomepage();
      }

      if (!empty($this->session->auth()->profile_id)) {
        $this->url->redirect('users/registerPrcNumber');
      }

      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $data = [
          'prc_number' => '',

          'prc_number_err' => '',
        ];

        $this->view('users/searchProfileBeforeRegister', $data);
        return;
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'prc_number' => trim($_POST['prc_number']),

        'prc_number_err' => ''
      ];

      // Validate prc info
      if (empty($data['prc_number'])) {
        $data['prc_number_err'] = 'Please enter your prc number';
      }

      // Check if errors are empty
      if (empty($data['prc_number_err'])) {
        // if prc_number is existing
        if ($this->profileModel->hasRow(['prc_number'], [trim($data['prc_number'])])) {
          $profile = $this->profileModel->find(
            ['*'],
            ['prc_number'],
            [$data['prc_number']]
          );

          $this->userModel->update3(
            ['profile_id'],
            [$profile->id],
            'id',
            $this->session->auth()->id
          );

          $user = $this->session->auth(false);

          $this->createUserSession($user);
          return;
        }

        $lastInsertedProfile = $this->profileModel->store2(
          ['prc_number'],
          [$data['prc_number']]
        );

        $this->userModel->update3(
          ['profile_id'],
          [$lastInsertedProfile->id],
          'id',
          $this->session->auth()->id
        );

        $this->session->set(SessionManager::SESSION_CURRENT_REGS_STEP, 'registerPrcInfo');
        $this->url->redirect('users/registerPrcInfo');
        return;
      }
      // Load view with errors
      $this->view('users/searchProfileBeforeRegister', $data);
    } catch (\Throwable $th) {
      $data = [
        'prc_number' => '',

        'prc_number_err' => $th->getCode() == '23000' ? 'Profile is already taken. Try again.' : $th->getMessage(),
      ];

      $this->view('users/searchProfileBeforeRegister', $data);
    }
  }

  /* 
    Registers/updates user info during
    post-registration
  */
  public function registerPrcInfo()
  {
    $this->session->start();
    if (!$this->isLoggedin() || !$this->isPasswordRegistered()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
      $this->url->redirectToHomepage();
    }

    if (empty($this->session->auth()->profile_id)) {
      $this->url->redirect('users/searchProfileBeforeRegister');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $this->session->auth()->id ?? '',

        'prc_number' => $this->session->auth()->prc_number,
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
        if ($this->profileModel->update2(
          [
            'prc_number',
            'prc_registration_date',
            'prc_expiration_date',
            'field_practice',
            'type_practice'
          ],
          [
            $data['prc_number'],
            $data['prc_registration_date'],
            $data['prc_expiration_date'],
            $data['field_practice'],
            $data['type_practice']
          ],
          'id',
          $this->session->auth()->profile_id
        )) {
          $this->session->set(SessionManager::SESSION_CURRENT_REGS_STEP, 'registerPersonalInfo');
          $this->url->redirect('users/registerPersonalInfo');
          return;
        }
      }
      // Load view with errors
      $this->view('users/registerPrcInfo', $data);
    } else {

      $user = $this->session->auth();

      $data = [
        'prc_number' => $user->prc_number ?? '',
        'prc_registration_date' => $user->prc_registration_date ?? '',
        'prc_expiration_date' => $user->prc_expiration_date ?? '',
        'field_practice' => $user->field_practice ?? '',
        'type_practice' => $user->type_practice ?? '',

        'prc_number_err' => '',
        'prc_registration_date_err' => '',
        'prc_expiration_date_err' => '',
        'field_practice_err' => '',
        'type_practice_err' => '',
      ];

      $this->view('users/registerPrcInfo', $data);
    }
  }
  public function registerPersonalInfo()
  {
    $this->session->start();

    if (!$this->isLoggedin() || !$this->isPasswordRegistered()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
      $this->url->redirectToHomepage();
    }

    if (empty($this->session->auth()->profile_id)) {
      $this->url->redirect('users/searchProfileBeforeRegister');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $this->session->auth()->id ?? '',

        'first_name' => trim($_POST['first_name']),
        'middle_name' => trim($_POST['middle_name']),
        'last_name' => trim($_POST['last_name']),
        'birthdate' => trim($_POST['birthdate']),
        'gender' => trim($_POST['gender']),
        'contact_number' => trim($_POST['contact_number']),
        'fb_account_name' => trim($_POST['fb_account_name']),
        'address' => trim($_POST['address']),

        'first_name_err' => '',
        'middle_name_err' => '',
        'last_name_err' => '',
        'gender_err' => '',
        'fb_account_name_err' => '',
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
      if (empty($data['address'])) {
        $data['address_err'] = 'Please enter your home address';
      }

      // Check if errors are empty
      if (
        empty($data['first_name_err']) && empty($data['middle_name_err'])
        && empty($data['last_name_err']) && empty($data['birthdate_err'])
        && empty($data['gender_err']) && empty($data['contact_number_err'])
        && empty($data['fb_account_name_err']) && empty($data['address_err'])
      ) {

        if ($this->profileModel->update2(
          [
            'first_name',
            'middle_name',
            'last_name',
            'birthdate',
            'gender',
            'contact_number',
            'fb_account_name',
            'address'
          ],
          [
            $data['first_name'],
            $data['middle_name'],
            $data['last_name'],
            $data['birthdate'],
            $data['gender'],
            $data['contact_number'],
            $data['fb_account_name'],
            $data['address'],
          ],
          'id',
          $this->session->auth()->profile_id
        )) {
          $this->session->set(SessionManager::SESSION_CURRENT_REGS_STEP, 'registerClinicInfo');
          $this->url->redirect('users/registerClinicInfo');
          return;
        }
      } else {
        // Load view with errors
        $this->view('users/registerPersonalInfo', $data);
      }
    } else {
      $user = $this->session->auth();

      $data = [
        'first_name' => $user->first_name ?? '',
        'middle_name' => $user->middle_name ?? '',
        'last_name' => $user->last_name ?? '',
        'gender' => $user->gender ?? '',
        'fb_account_name' => $user->fb_account_name ?? '',
        'contact_number' => $user->contact_number ?? '',
        'birthdate' => $user->birthdate ?? '',
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

      $this->view('users/registerPersonalInfo', $data);
    }
  }
  public function registerClinicInfo()
  {
    $this->session->start();

    if (!$this->isLoggedin() || !$this->isPasswordRegistered()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
      $this->url->redirectToHomepage();
    }

    if (empty($this->session->auth()->profile_id)) {
      $this->url->redirect('users/searchProfileBeforeRegister');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $this->session->auth()->id ?? '',

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
        if ($this->profileModel->update2(
          [
            'clinic_name',
            'clinic_street',
            'clinic_district',
            'clinic_city',
            'clinic_contact'
          ],
          [
            $data['clinic_name'],
            $data['clinic_street'],
            $data['clinic_district'],
            $data['clinic_city'],
            $data['clinic_contact_number']
          ],
          'id',
          $this->session->auth()->profile_id
        )) {
          $this->session->set(SessionManager::SESSION_CURRENT_REGS_STEP, 'registerEmergencyInfo');
          $this->url->redirect('users/registerEmergencyInfo');
          return;
        }
      } else {
        // Load view with errors
        $this->view('users/registerClinicInfo', $data);
      }
    } else {
      $user = $this->session->auth();

      $data = [
        'clinic_name' => $user->clinic_name,
        'clinic_street' => $user->clinic_street,
        'clinic_district' => $user->clinic_district,
        'clinic_city' => $user->clinic_city,
        'clinic_contact_number' => $user->clinic_contact,

        'clinic_name_err' => '',
        'clinic_street_err' => '',
        'clinic_district_err' => '',
        'clinic_city_err' => '',
        'clinic_contact_number_err' => '',
      ];
      // Load view
      $this->view('users/registerClinicInfo', $data);
    }
  }
  public function registerEmergencyInfo()
  {
    $this->session->start();

    if (!$this->isLoggedin() || !$this->isPasswordRegistered()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedin() && $this->isEmailVerified() && $this->isCompleteInfo()) {
      $this->url->redirectToHomepage();
    }

    if (empty($this->session->auth()->profile_id)) {
      $this->url->redirect('users/searchProfileBeforeRegister');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $this->session->auth()->id ?? '',

        'emergency_person_name' => trim($_POST['emergency_person_name']),
        'emergency_address' => trim($_POST['emergency_address']),
        'emergency_contact_number' => trim($_POST['emergency_contact_number']),

        'emergency_person_name_err' => '',
        'emergency_address_err' => '',
        'emergency_contact_number_err' => '',
      ];

      // Validate case of emergency info
      if (empty($data['emergency_person_name'])) {
        $data['emergency_person_name_err'] = 'Please enter the name of your case of emergency contact';
      }
      if (empty($data['emergency_address'])) {
        $data['emergency_address_err'] = 'Please enter the name of their address';
      }
      if (empty($data['emergency_contact_number'])) {
        $data['emergency_contact_number_err'] = 'Please enter their contact number';
      }

      if (
        empty($data['emergency_person_name_err']) && empty($data['emergency_address_err'])
        && empty($data['emergency_contact_number_err'])
      ) {
        if ($this->profileModel->update2(
          [
            'emergency_person_name',
            'emergency_address',
            'emergency_contact_number'
          ],
          [
            $data['emergency_person_name'],
            $data['emergency_address'],
            $data['emergency_contact_number']
          ],
          'id',
          $this->session->auth()->profile_id
        )) {
          $user = $this->session->auth();
          $this->createUserSession($user);
          return;
        }
      } else {
        // Load view with errors
        $this->view('users/registerEmergencyInfo', $data);
      }
    } else {
      $user = $this->session->auth();

      $data = [
        'emergency_person_name' => $user->emergency_person_name ?? '',
        'emergency_address' => $user->emergency_address ?? '',
        'emergency_contact_number' => $user->emergency_contact_number ?? '',

        'emergency_person_name_err' => '',
        'emergency_address_err' => '',
        'emergency_contact_number_err' => '',
      ];
      // Load view
      $this->view('users/registerEmergencyInfo', $data);
    }
  }

  /* 
    generates a temporary email and then 
    pass the user to handleUserRegistration()
    with a confirmation type of 'change'
  */
  public function updateEmail()
  {
    $this->session->start();

    if (!$this->isLoggedin() || !$this->isEmailVerified()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedin() && $this->isPasswordRegistered() && !$this->isCompleteInfo()) {
      $this->url->redirect('users/registerPrcInfo');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'current_email' => $this->session->auth()->email,
        'email' => trim($_POST['email']) ?? '',
        'password' => trim($_POST['password']) ?? '',
        'confirm_password' => trim($_POST['confirm_password']) ?? '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter your email';
        }

        if ($this->userModel->find(['*'], ['email'], [$data['email']])) {
          $data['email_err'] = 'Email is already taken';
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
        empty($data['email_err']) &&
        empty($data['password_err']) &&
        empty($data['confirm_password_err'])
      ) {
        // Check and set logged in user
        // $verifiedUser = $this->userModel->getVerifiedUserByEmail($data['current_email']);
        $verifiedUser = $this->userModel->find(
          ['*'],
          ['email', 'email_verified'],
          [$data['current_email'], true]
        );

        if (!$verifiedUser) {
          $this->view('users/redirectPage', $data = ['message' => 'Current email is not verified']);
          return;
        }

        $hashed_password = $verifiedUser->password;
        if (password_verify($data['password'], $hashed_password)) {
          // if (!$this->userModel->storeNewEmail($data)) {
          //   $this->view('users/redirectPage', $data = ['message' => 'New email was not stored']);
          //   return;
          // }          
          $this->userModel->update4(
            ['new_email', 'changing_email'],
            [$data['email'], true],
            ['email', 'email_verified'],
            [$data['current_email'], true]
          );

          $this->handleUserRegistration(
            [
              'email_confirmation_type' => 'CHANGE_EMAIL',
              'id_type' => 'email',
              'id' => $data['current_email'],
              'receiver_email' => $data['email'],
              'vkey' => $this->userModel->regenerateVkey('change_email_vkey', 'email', $data['current_email']),
              'vkeyType' => 'change_email_vkey'
            ]
          );
        } else {
          $data['password_err'] = 'Password incorrect';

          $this->view('users/changeEmail', $data);
        }
      } else {
        // Load view with errors
        $this->view('users/changeEmail', $data);
      }
    } else {

      $data = [
        'current_route' => 'userInfo',
        'email' => $this->session->auth()->email,
        'password' => '',
        'confirm_password' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      $this->view('users/changeEmail', $data);
    }
  }

  public function createUserSession(object $user = null): void
  {
    if (empty($user)) {
      exit($this->view('users/redirectPage', ['message' => 'You are illegally accessing a route']));
    }

    $this->session->start()
      ->set(SessionManager::SESSION_EMAIL_VERIFIED, $user->email_verified ? true : false)
      ->set(SessionManager::SESSION_USER, $user)
      ->set(SessionManager::SESSION_LOGIN_TIMESTAMP, time())
      ->set(SessionManager::SESSION_PASS_REGISTERED, true);

    if (empty($user->email) && empty($user->password)) {
      $this->session->start()
        ->set(SessionManager::SESSION_PASS_REGISTERED, false);

      $this->url->redirect('users/registerEmailPassword');
      return;
    }

    if ($this->role->isSuperAdmin($user->role)) {
      $this->session->start()->set(SessionManager::SESSION_COMPLETE_INFO, true);

      if ($this->isLoggedIn()) {
        $this->url->redirectToHomepage();
      }
      return;
    }

    // !! change birthdate to clinic_name after joining 2 tables !!
    if (
      empty($user->profile_id)
    ) {
      // dd($user);
      $this->session->start()->set(SessionManager::SESSION_COMPLETE_INFO, false);
      $this->url->redirect('users/searchProfileBeforeRegister');
      return;
    }

    $userProfile = $this->session->auth();

    // check if profile has empty fields
    if (
      empty($userProfile->first_name) || empty($userProfile->last_name)
      || empty($userProfile->prc_number) || empty($userProfile->clinic_name)
    ) {
      $this->session->start()
        ->set(SessionManager::SESSION_COMPLETE_INFO, false)
        ->set(SessionManager::SESSION_CURRENT_REGS_STEP, 'registerPrcInfo');
      $this->url->redirect('users/registerPrcInfo');
      return;
    }

    $this->session->start()->set(SessionManager::SESSION_COMPLETE_INFO, true);
    $this->activityModel->store(
      [
        'user_id' => $user->id,
        'initiator' => arrangeFullname($user->first_name, $user->middle_name, $user->last_name),
        'message' => arrangeFullname($user->first_name, $user->middle_name, $user->last_name) . ' (' . $user->role . '): logged in successfully',
        'type' => 'user_login',
      ]
    );
    $this->url->redirectToHomepage();
  }

  public function logout(): void
  {
    if (!$this->isLoggedin()) {
      $this->url->redirectToLoginpage();
    }

    $this->session->clear();
    $this->url->redirect('users/login');
  }

  public function restartSessionTimer()
  {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
      throw new Error('Your request method must be in \'POST\'');
    }

    $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
    $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';

    if (strpos($contentType, 'multipart/form-data') === false) {
      throw new Error('Your content type must be in \'multipart/form-data\'');
    }

    if (empty($_POST['current_timestamp'])) {
      throw new Error('The body must contain the params \'current_timestamp\' and it should not have an empty value.');
    }

    if (!$this->isLoggedin()) {
      $this->url->redirectToLoginpage();
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['current_timestamp'])) {
      $this->session->set(SessionManager::SESSION_LOGIN_TIMESTAMP, $_POST['current_timestamp']);

      header("Content-Type: application/json; charset=UTF-8");
      exit(json_encode(['status' => 'ok', 'message' => 'Session timer was successfully restarted', 'data' => ['session_login_timestamp' => $this->session->get(SessionManager::SESSION_LOGIN_TIMESTAMP)]]));
    }
  }

  public function downloadTemplates()
  {
    if (isset($_GET['filename'])) {
      $filename = $_GET['filename'];

      if (!in_array($filename, ['IMPORT_DUES_TEMPLATE.xlsx', 'IMPORT_PROFILES_TEMPLATE.xlsx'])) {
        throw new Error('Parameters are not correct');
      }

      //Read the filename
      $path = APPROOT . '/storage/';
      $fullPath = $path . $filename;

      //Check the file exists or not
      if (file_exists($fullPath)) {
        //Define header information
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header("Cache-Control: no-cache, must-revalidate");
        header("Expires: 0");
        header('Content-Disposition: attachment; filename="' . basename($fullPath) . '"');
        header('Content-Length: ' . filesize($fullPath));
        header('Pragma: public');

        //Clear system output buffer
        flush();

        //Read the size of the file
        readfile($fullPath);

        //Terminate from the script
        die();
      }
    }
  }
}

  // public function removeThirdPartyAuth($authChannel = null)
  // {
  //   if (isset($_GET['authChannel']) && !isset($authChannel)) {
  //     $authChannel = $_GET['authChannel'];
  //     // $user = $this->userModel->getUserById($this->session->auth()->id);
  //     // if ($user->username || $user->fb_user_id || $user->gmail_user_id) {
  //     // }

  //     if ($authChannel == 'facebook') {
  //       if ($this->userModel->removeThirdPartyAuth('fb_user_id', 'fb_access_token', $this->session->auth()->id)) {
  //         $this->url->redirect('profiles/userInfo');
  //       }
  //     } else if ($authChannel == 'google') {
  //       if ($this->userModel->removeThirdPartyAuth('google_user_id', 'google_access_token', $this->session->auth()->id)) {
  //         $this->url->redirect('profiles/userInfo');
  //       }
  //     } else {
  //       $this->view('users/redirectPage', $data = ['message' => 'This auth channel does not exist. Try again.']);
  //     }
  //   }
  // }