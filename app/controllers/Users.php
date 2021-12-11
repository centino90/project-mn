<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Users extends Controller
{
  public function __construct()
  {
    $this->userModel = $this->model('User');
    // $this->dog = new Mailer;
  }

  public function index()
  {
    // $this->view('inc/templateVerifyEmail');
    redirect('users/login');
  }

  /* ALL ACCESSIBLE ENDPOINTS */
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
          $this->createUserSession($fb['user'], false);
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
          $this->createUserSession($gg['user'], false);
        } else if ($gg['added']) {
          $this->view('users/redirectPage', $gg);
        }
      }
    }
  }

  /* GUEST ACCESSIBLE ENDPOINTS */
  public function login(string $authMessage = ''): void
  {
    redirectAuthUserWithRole();

    // if (isset($_GET['code'])) {
    //   // try and log the user in with $_GET code from google 
    //   $gg = tryAndLoginWithGoogle($_GET, $this);
    //   $data = $gg;

    //   if ($gg['status'] == 'fail') {
    //     if ($gg['reason'] == 'unverifiedEmail') {
    //       $_SESSION['email_confirmation_info'] = $gg['emailConfirmation'];
    //       $this->view('users/redirectPage', $data);
    //     } else {
    //       $this->view('users/redirectPage', $data);
    //     }
    //   } else if ($gg['status'] == 'ok') {
    //     if ($gg['user']) {
    //       $this->createUserSession($gg['user'], false);
    //     } else if ($gg['emailConfirmation']) {
    //       $this->handleUserRegistration($gg['emailConfirmation']);
    //     } else if ($gg['added']) {
    //       $this->view('users/redirectPage', $data);
    //     }
    //   }
    // }
  }

  public function handleRegisterConfirmation()
  {
    // die(var_dump($_POST));
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $d = $this->userModel->updateAuthCredentials(
        [
          'access_token' => 'fb_access_token',
          'auth_id' => 'fb_user_id'
        ],
        [
          'access_token' => $_POST['access_token'],
          'auth_id' => $_POST['auth_id'],
        ],
        $_POST['user_id']
      );
      die($d);
      // $userModel->updateUserById('fb_user_id', $fbUserInfo['fb_response']['id'], $userInfoWithEmail->id);
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

          $rows = $this->userModel->getRowsWithColumns(['id', 'account_registration_vkey'], [$userId, $accountRegistrationVkey]);

          if ($rows) {
            if (!$this->userModel->verifyEmail(
              [
                'user_id' => $rows[0]->id,
                'email_vkey' => $rows[0]->email_vkey,
                'email_verified' => true
              ]
            )) {
              // if user id or verification key is not correct
              $this->view('users/redirectPage', ['message' => 'User verification failed. Try again.']);
              return;
            }

            $verifiedUser = $this->userModel->getRowsWithColumns(['id', 'email_verified'], [$userId, true]);
            if ($verifiedUser) {
              $this->userModel->regenerateVkey('account_registration_vkey', 'email', $rows[0]->email);
              $this->createUserSession($verifiedUser[0]);
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

          $rows = $this->userModel->getRowsWithColumns(['id', 'change_email_vkey'], [$userId, $changeEmailVkey]);

          if ($rows) {
            if ($rows[0]->email_verified && !$rows[0]->changing_email) {
              $this->view('users/redirectPage', ['message' => 'This verification key is already used or replaced.']);
              return;
            } else if ($rows[0]->email_verified && $rows[0]->changing_email) {
              if ($newEmail != $rows[0]->new_email) {
                $this->view('users/redirectPage', ['message' => 'These credentials are not correct. Try again.']);
                return;
              }

              if (!$this->userModel->changeEmail(
                [
                  'user_id' => $rows[0]->id,
                  'email_vkey' => $rows[0]->email_vkey,
                  'new_email' => $rows[0]->new_email
                ]
              )) {
                $this->view('users/redirectPage', ['message' => 'User verification failed. Try again.']);
                return;
              }

              if ($this->userModel->updateRowById('changing_email', false, $rows[0]->id)) {
                $this->view('users/redirectPage', ['message' => 'Your email was successfully changed. Sign in again.']);
                sessionDestroyAll();
              }
            } else {
              die('not verified');
            }
          } else {
            $this->view('users/redirectPage', $data = ['message' => 'These verification credentials are not correct.']);
          }
        }
      } elseif ($confirmationType == 'FORGOT_PASSWORD') {
        if (isset($_GET['id']) && isset($_GET['vkey'])) {
          $userId = $_GET['id'];
          $forgotPasswordVkey = $_GET['vkey'];

          $rows = $this->userModel->getRowsWithColumns(['id', 'forgot_password_vkey'], [$userId, $forgotPasswordVkey]);

          if ($rows) {
            if (empty($rows[0]->new_password)) {
              $this->view('users/redirectPage', ['message' => 'This verification key is already used or replaced.']);
              return;
            }
            $newPassword = $this->userModel->resetPasswordAndReturnUnencryptedVersion($rows[0]->id, $rows[0]->email_vkey);

            if ($this->userModel->updateRowById('new_password', null, $rows[0]->id)) {
              $this->view('users/redirectPage', ['message' => 'Your password was successfully resetted. Here is your new password: <b>' . $newPassword . '</b>', 'reason' => 'passwordReset', 'email' => $rows[0]->email]);
              sessionDestroyAll();
            }
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

    $unverifiedUser = $this->userModel->getRowByColumn($data['id_type'], $data['id']);
    if ($unverifiedUser) {
      $mail = new PHPMailer(true);

      try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->Port       = MAIL_PORT;
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom(MAIL_FROM_ADDRESS, 'pda-dcc.com');
        $mail->addAddress($data['receiver_email'], 'PDA-DCC member');

        //Content
        $email_template = APPROOT . '/views/inc/templateVerifyEmail.php';
        $verify_url = URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->$vkeyType;
        $about_url = URLROOT . '/about';
        $privacy_url = URLROOT . '/about/privacy';
        $terms_url = URLROOT . '/about/terms';
        $subject = 'PDA-DCC ' . str_replace('_', ' ', $data['email_confirmation_type']) . ' VERIFICATION';

        $message = file_get_contents($email_template);
        $message = str_replace('{{verify_url}}', $verify_url, $message);
        $message = str_replace('{{about_url}}', $about_url, $message);
        $message = str_replace('{{privacy_url}}', $privacy_url, $message);
        $message = str_replace('{{terms_url}}', $terms_url, $message);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        // $mail->Body    =  '<h1>Confirm Registration</h1>' .
        //   'Click this <a href="' . URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->email_vkey . '">link</a> to continue registration';
        // // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
        if (isset($data['logoutAfter']) && $data['logoutAfter']) {
          sessionDestroyAll();
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
        if (!$this->userModel->deleteUser('email', $data['email'], false, false)) {
          $this->view('users/redirectPage', $data = ['message' => 'Oooops. Something went wrong. Try again.']);
        }

        // show abort message
        $this->view('users/redirectPage', ['message' => 'Your registration was successfully cancelled. Your email is now again open for registration.']);
      } else {
        // Load view with errors
        $this->view('users/register', $data);
      }
    } else {

      die('yes');
    }
  }

  /* GUEST ACCESSIBLE ENDPOINTS */
  public function login(string $authMessage = ''): void
  {
    redirectAuthUserWithRole();

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
        $requestedUser = $this->userModel->getRowByColumn('email', $data['email']);
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
    redirectAuthUserWithRole();

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

        if ($this->userModel->findUserByEmail($data['email'])) {
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

        if (!$this->userModel->register($data)) {
          $this->view('users/redirectPage', $data = ['message' => 'Oooops. Something went wrong. Try again.']);
        }

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

  /* 
    confirm if email exist and then send 
    pword and email to pword reset handler
  */
  public function forgotPassword()
  {
    // redirectAuthUserWithRole();

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

        if (!$this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email not found';
        }
      }

      // Check if all errors are empty
      if (empty($data['email_err']) && empty($data['g_recaptcha_response_err'])) {
        if (!$this->userModel->storeNewPassword($data['email'])) {
          $this->view('users/redirectPage', $data = ['message' => 'New password was not stored. Try again']);
          return;
        }

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

  /* 
    *Accepts both post and get requests*
    post: form-based password reset request
    get: link-based password reset request (for rerequest or resend usecase)

    Resets password and return its unencrypted value
    and send it to the requestor's email
  */
  public function handlePasswordResetRequest($data = null)
  {
    $unverifiedUser = $this->userModel->getRowByColumn($data['id_type'], $data['id']);
    if ($unverifiedUser) {
      $mail = new PHPMailer(true);

      try {
        //Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                  
        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->Port       = MAIL_PORT;
        $mail->SMTPSecure = 'tls';

        //Recipients
        $mail->setFrom(MAIL_FROM_ADDRESS, 'Mailer');
        $mail->addAddress($data['receiver_email'], 'Regitering user');

        //Content
        // $email_template = APPROOT . '/views/inc/templatePasswordReset.php';
        $email_template = APPROOT . '/views/inc/templateVerifyEmail.php';
        // $password = $this->userModel->resetPasswordAndReturnUnencryptedVersion($unverifiedUser->id);
        $verify_url = URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->forgot_password_vkey;
        $about_url = URLROOT . '/about';
        $privacy_url = URLROOT . '/about/privacy';
        $terms_url = URLROOT . '/about/terms';
        $subject = 'PDA-DCC ' . str_replace('_', ' ', $data['email_confirmation_type']) . ' VERIFICATION';

        $message = file_get_contents($email_template);
        // $message = str_replace('{{password}}', $password, $message);
        $message = str_replace('{{verify_url}}', $verify_url, $message);
        $message = str_replace('{{about_url}}', $about_url, $message);
        $message = str_replace('{{privacy_url}}', $privacy_url, $message);
        $message = str_replace('{{terms_url}}', $terms_url, $message);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
        $this->view('users/redirectPage', $data = ['message' => 'A confirmation link was just sent to ' . $data['receiver_email'] . '. The changes will take effect after you have clicked the link.', 'email' => $data['receiver_email']]);
        // $this->view('users/redirectPage', $data = ['message' => 'Your new password was sent to your email.', 'reason' => 'passwordReset', 'email' => $data['receiver_email']]);
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }

  /* AUTH ACCESSIBLE ENDPOINTS */

  public function registerEmailPassword()
  {
    redirectIfNotLoggedIn();
    redirectIfEmailAndPassRegistered();
    redirectFullyRegisteredUser();

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

        if ($this->userModel->findUserByEmail($data['email'])) {
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

        if (!$this->userModel->updateRowsById(['email', 'password'], [$data['email'], $data['password']], $_SESSION['user_id'])) {
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
  public function changeRegisteredEmail()
  {
    // redirectIfNotAuthUser();
    // if()

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'email' => trim($_POST['email']),

        'email_err' => '',
      ];

      // Validate login credentials
      if (empty($data['email'])) {
        $data['email_err'] = 'Please enter your email';
      } else {
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
          $data['email_err'] = 'Please enter your email';
        }

        if ($this->userModel->findUserByEmail($data['email'])) {
          $data['email_err'] = 'Email is already taken';
        }
      }

      // Check if all errors are empty
      if (
        empty($data['email_err'])
      ) {
        if (!$this->userModel->updateRowById('email', $data['email'], $_SESSION['user_id'])) {
          $data['email_err'] = 'Something went wrong';
          $this->view('users/registerEmailPassword', $data);
          return;
        }

        $this->handleUserRegistration(
          [
            'email_confirmation_type' => 'register',
            'id_type' => 'email',
            'id' => $data['email'],
            'receiver_email' => $data['email'],
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

  /* 
    *triggered when user sign in using 3rd party auths*

    Registers user password to a newly created user
    and redirects to the *steps*
  */
  public function registerPassword()
  {
    redirectIfNotAuthUser();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'password' => trim($_POST['password']),
        'confirm_password' => trim($_POST['confirm_password']),

        'password_err' => '',
        'confirm_password_err' => ''
      ];

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
        empty($data['password_err']) && empty($data['confirm_password_err'])
      ) {
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

        if (!$this->userModel->updateRowById('password', $data['password'], $_SESSION['user_id'])) {
          $data['password_err'] = 'Something went wrong';
          $this->view('users/registerPassword', $data);
          return;
        }

        $_SESSION['password_registered'] = false;
        redirect('users/registerPrcInfo');
      } else {
        // Load view with errors
        $this->view('users/registerPassword', $data);
      }
    } else {

      $data = [
        'password' => '',
        'confirm_password' => '',

        'password_err' => '',
        'confirm_password_err' => ''
      ];

      $this->view('users/registerPassword', $data);
    }
  }

  /* 
    Endpoints for Steps (1 to 4) during registration

    All: they share the same pattern of redirecting from
    the low to high (step 1 to step ...) or redirecting from high
    to low. All have standard setups (input validation, user update
    queries, etc.)

    Step 4. RegisterEmergencyInfo: creates user session and redirects
    to the home page.
  */
  public function registerPrcInfo()
  {
    // redirectIfNotAuthUser();
    redirectIfNotLoggedIn();
    redirectIfEmailAndPassNotRegistered();
    redirectFullyRegisteredUser();
    redirectInactiveUserOrRegenerateTimer();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

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
          $_SESSION['current_registration_step'] = 'registerPersonalInfo';
          redirect('users/registerPersonalInfo');
          return;
        }
        die('Something went wrong');
        return;
      }
      // Load view with errors
      $this->view('users/registerPrcInfo', $data);
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

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
    redirectIfNotAuthUser();
    redirectFullyRegisteredUser();
    redirectInactiveUserOrRegenerateTimer();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

        'first_name' => trim($_POST['first_name']),
        'middle_name' => trim($_POST['middle_name']),
        'last_name' => trim($_POST['last_name']),
        'birthdate' => trim($_POST['birthdate']),
        'gender' => trim($_POST['gender']),
        'contact_number' => trim($_POST['contact_number']),
        'email' => trim($_POST['email']),
        'fb_account_name' => trim($_POST['fb_account_name']),
        'address' => trim($_POST['address']),

        'first_name_err' => '',
        'middle_name_err' => '',
        'last_name_err' => '',
        'gender_err' => '',
        'email_err' => '',
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

      // Check if errors are empty
      if (
        empty($data['first_name_err']) && empty($data['middle_name_err'])
        && empty($data['last_name_err']) && empty($data['birthdate_err'])
        && empty($data['gender_err']) && empty($data['contact_number_err'])
        && empty($data['fb_account_name_err']) && empty($data['email_err'])
        && empty($data['address_err'])
      ) {

        if ($this->userModel->updatePersonalInfo($data)) {
          $_SESSION['current_registration_step'] = 'registerClinicInfo';
          redirect('users/registerClinicInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerPersonalInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'first_name' => $user->first_name ?? '',
        'middle_name' => $user->middle_name ?? '',
        'last_name' => $user->last_name ?? '',
        'gender' => $user->gender ?? '',
        'fb_account_name' => $user->fb_account_name ?? '',
        'email' => $user->email ?? '',
        'contact_number' => $user->contact_number ?? '',
        'birthdate' => $user->birthdate ?? '',
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

      $this->view('users/registerPersonalInfo', $data);
    }
  }
  public function registerClinicInfo()
  {
    redirectIfNotAuthUser();
    redirectFullyRegisteredUser();
    redirectInactiveUserOrRegenerateTimer();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
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
          redirect('users/registerEmergencyInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerClinicInfo', $data);
      }
    } else {
      $clinic = $this->model('Clinic')->getClinicById($_SESSION['user_id']);

      $data = [
        'clinic_name' => $clinic->name ?? '',
        'clinic_street' => $clinic->street ?? '',
        'clinic_district' => $clinic->district ?? '',
        'clinic_city' => $clinic->city ?? '',
        'clinic_contact_number' => $clinic->contact_number ?? '',

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
    redirectIfNotAuthUser();
    redirectFullyRegisteredUser();
    redirectInactiveUserOrRegenerateTimer();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'user_id' => $_SESSION['user_id'] ?? '',

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
        if ($this->userModel->updateEmergencyInfo($data)) {
          $user = $this->userModel->getUserById($_SESSION['user_id']);

          if ($this->userModel->updateRowById('is_active', true, $_SESSION['user_id'])) {
            $this->createUserSession($user);
          }
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('users/registerEmergencyInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

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
    pass the subjected user to handleUserRegistration()
    with a confirmation type of 'change'
  */
  public function updateEmail()
  {
    redirectIfNotAuthUser();

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'current_email' => $_SESSION['user_email'],
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

        if ($this->userModel->findUserByEmail($data['email'])) {
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
        $verifiedUser = $this->userModel->getVerifiedUserByEmail($data['current_email']);

        if (!$verifiedUser) {
          $this->view('users/redirectPage', $data = ['message' => 'Current email is not verified']);
          return;
        }

        $hashed_password = $verifiedUser->password;
        if (password_verify($data['password'], $hashed_password)) {
          if (!$this->userModel->storeNewEmail($data)) {
            $this->view('users/redirectPage', $data = ['message' => 'New email was not stored']);
            return;
          }

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
          // if ($this->userModel->updateRowById('changing_email', true, $verifiedUser->id)) {

          // }
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
        'email' => $_SESSION['user_email'],
        'password' => '',
        'confirm_password' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ];

      $this->view('users/changeEmail', $data);
    }
  }

  public function createUserSession(object $user, bool $notThirdParty = true): void
  {
    $_SESSION['email_verified'] = $user->email_verified ? true : false;
    $_SESSION['user_id'] = $user->id;
    $_SESSION['user_email'] = $user->email;
    $_SESSION['user_username'] = $user->username;
    $_SESSION['user_name'] = ucwords($user->last_name) . ', ' . ucwords($user->first_name) . ' ' . ucwords(substr($user->middle_name, 0, 1) . '.');
    $_SESSION['role'] = $user->role;
    $_SESSION['password_registered'] = true;

    if (empty($user->email) && empty($user->password)) {
      $_SESSION['password_registered'] = false;
      $_SESSION["login_time_stamp"] = time();

      $this->view('users/registerEmailPassword', [
        'email' => '',
        'password' => '',
        'confirm_password' => '',

        'email_err' => '',
        'password_err' => '',
        'confirm_password_err' => '',
      ]);
    }

    if (
      $notThirdParty && !empty($user->middle_name) && !empty($user->birthdate)
      && !empty($user->prc_number) && !empty($user->emergency_person_name)
    ) {
      // flash('login_status', 'You just signed in successfully!');

      $_SESSION['complete_info'] = true;
      $_SESSION["login_time_stamp"] = time();

      redirectAuthUserWithRole();
    } else if (
      !$notThirdParty && !empty($user->middle_name) && !empty($user->birthdate)
      && !empty($user->prc_number) && !empty($user->emergency_person_name)
    ) {
      // flash('login_status', 'You just signed in successfully!');

      $_SESSION['complete_info'] = true;
      $_SESSION["login_time_stamp"] = time();

      redirectAuthUserWithRole();
    } else {
      // flash('login_status', 'Proceed to finish registration', 'You are either signed in using 3rd party authenthication or missed some inputs along the steps.');
      $_SESSION['complete_info'] = false;
      $_SESSION["login_time_stamp"] = time();


      redirectNotFullyRegisteredUser();
    }
  }

  public function logout()
  {
    redirectIfNotAuthUser();

    sessionDestroyAll();
    redirect('users/login');
  }

  public function restartSessionTimer()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['current_timestamp'])) {
      // session_regenerate_id(true);
      $_SESSION['login_time_stamp'] = $_POST['current_timestamp'];

      echo json_encode(['ok' => true, 'status' => 200, 'message' => 'Session timer was successfully restarted']);
    }
  }

  public function __destruct()
  {
    // unset($_SESSION['email_confirmation_info']);
  }


  // public function removeThirdPartyAuth($authChannel = null)
  // {
  //   if (isset($_GET['authChannel']) && !isset($authChannel)) {
  //     $authChannel = $_GET['authChannel'];
  //     // $user = $this->userModel->getUserById($_SESSION['user_id']);
  //     // if ($user->username || $user->fb_user_id || $user->gmail_user_id) {
  //     // }

  //     if ($authChannel == 'facebook') {
  //       if ($this->userModel->removeThirdPartyAuth('fb_user_id', 'fb_access_token', $_SESSION['user_id'])) {
  //         redirect('profiles/userInfo');
  //       }
  //     } else if ($authChannel == 'google') {
  //       if ($this->userModel->removeThirdPartyAuth('google_user_id', 'google_access_token', $_SESSION['user_id'])) {
  //         redirect('profiles/userInfo');
  //       }
  //     } else {
  //       $this->view('users/redirectPage', $data = ['message' => 'This auth channel does not exist. Try again.']);
  //     }
  //   }
  // }


  // public function validateAndCheckEmptyInputs($data)
  // {
  //   // Validate prc info
  //   foreach ($data as $key => $value) {
  //     if (empty($value)) {
  //       $data[$key . '_err'] = 'Please enter your ' . str_replace('_', ' ', $key);
  //     }
  //   }

  //   die(var_dump($data));
  //   // if (empty($data['prc_number'])) {
  //   //   $data['prc_number_err'] = 'Please enter your prc number';
  //   // }
  //   // if (empty($data['prc_registration_date'])) {
  //   //   $data['prc_registration_date_err'] = 'Please enter your prc registration date';
  //   // }
  //   // if (empty($data['prc_expiration_date'])) {
  //   //   $data['prc_expiration_date_err'] = 'Please enter your prc expiration date';
  //   // }
  //   // if (empty($data['field_practice'])) {
  //   //   $data['field_practice_err'] = 'Please select your field of practice';
  //   // }
  //   // if (empty($data['type_practice'])) {
  //   //   $data['type_practice_err'] = 'Please select your type of practice';
  //   // }

  //   // Check if errors are empty
  //   if (empty($data['prc_number_err']) && empty($data['prc_registration_date_err']) && empty($data['prc_expiration_date_err']) && empty($data['field_practice_err']) && empty($data['type_practice_err'])) {
  //     return true;
  //   }
  //   return false;
  // }
}


// public function registerDuesInfo()
  // {
  //   if (!isLoggedIn()) {
  //     redirect('users/login');
  //   }
  //   if (isLoggedIn() && isCompleteInfo()) {
  //     redirect('profiles');
  //   }
  //   // if ($_SESSION['current_registration_step'] != 'registerDuesInfo') {
  //   //   redirect('users/' . $_SESSION['current_registration_step']);
  //   // }

  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  //     $data = [
  //       'user_id' => $_SESSION['user_id'] ?? '',
  //       'payment_option' => trim($_POST['payment_option']),
  //       'payment_option_err' => ''
  //     ];

  //     // Validate payment option
  //     if (empty($data['payment_option'])) {
  //       $data['payment_option_err'] = 'Please select your payment option';
  //     }

  //     if (empty($data['payment_option_err'])) {
  //       if ($this->userModel->updateDuesInfo($data)) {
  //         $user = $this->userModel->getUserById($_SESSION['user_id']);
  //         unset($_SESSION['current_registration_info']);
  //         $this->createUserSession($user);

  //       } else {
  //         die('Something went wrong');
  //       }
  //     } else {
  //       // Load view with errors
  //       $this->view('users/registerDuesInfo', $data);
  //     }
  //   } else {
  //     $user = $this->userModel->getUserById($_SESSION['user_id']);

  //     $data = [
  //       'payment_option' => $user->payment_option ?? '',

  //       'payment_option_err' => ''
  //     ];

  //     // Load view
  //     $this->view('users/registerDuesInfo', $data);
  //   }
  // }