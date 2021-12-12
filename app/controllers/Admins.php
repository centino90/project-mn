<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Admins extends Controller
{
  public function __construct()
  {
    redirectIfNotAuthUser();
    redirectNotFullyRegisteredUser();
    redirectIfNotAdmin();
    redirectInactiveUserOrRegenerateTimer();

    $this->userModel = $this->model('User');
    $this->clinicModel = $this->model('Clinic');
    $this->duesModel = $this->model('Dues');
  }

  public function index()
  {
    // die('yes');
    // Get payment history
    $data = [
      'current_route' => __FUNCTION__,

      'posts' => 'dogger'
    ];

    $this->view('admins/paymentHistory', $data);
    unset($_SESSION['login_success']);
    // redirect('admins/paymentHistory');
  }
  public function accounts()
  {
    $accounts = $this->userModel->userToClinic();
    $clinics = $this->clinicModel->getRows();

    // die(var_dump($members));
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'current_route' => __FUNCTION__,
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
          flash('update_success', 'Your license profile was updated');
          redirect('licenseInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('licenseInfo', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);

      $data = [
        'current_route' => __FUNCTION__,

        'accounts' => $accounts,
        // 'members' => $members,
        'clinics' => $clinics,
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

      $this->view('admins/accounts', $data);
    }
  }

  public function createAccount()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'current_route' => 'accounts',

        'role' => trim($_POST['role']),
        'email' => trim($_POST['email']),

        'role_err' => '',
        'email_err' => '',
      ];

      // Validate prc info
      if (empty($data['role'])) {
        $data['role_err'] = 'Please select a role';
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

      // Check if errors are empty
      if (empty($data['role_err']) && empty($data['email_err'])) {
        $autoPassword = uniqid();
        $data['password'] = password_hash($autoPassword, PASSWORD_DEFAULT);
        if (!$this->userModel->register($data)) {
          $this->view('users/redirectPage', $data = ['message' => 'Oooops. Something went wrong. Try again.']);
        }

        // initialize data to pass as params for email sending
        $this->handleUserRegistrationViaAdmin(
          [
            'email_confirmation_type' => 'ACCOUNT_REGISTRATION',
            'id_type' => 'email',
            'id' => $data['email'],
            'receiver_email' => $data['email'],
            'vkey' => $this->userModel->regenerateVkey('account_registration_vkey', 'email', $data['email']),
            'password' => $autoPassword
          ]
        );
      } else {
        // Load view with errors
        $this->view('admins/createAccount', $data);
      }
    } else {
      $data = [
        'current_route' => 'accounts',
        'role' => '',
        'email' => '',

        'role_err' => '',
        'email_err' => '',
      ];

      $this->view('admins/createAccount', $data);
    }
  }
  public function handleUserRegistrationViaAdmin($data = null)
  {
    if (!isset($data)) {
      $data = $_SESSION['email_confirmation_info'];
      $emailVkey = $this->userModel->regenerateEmailVkey($data['id_type'], $data['id']);

      $data['vkey'] = $emailVkey;
    }
    unset($_SESSION['email_confirmation_info']);

    $unverifiedUser = $this->userModel->getRowByColumn($data['id_type'], $data['id']);
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
        $mail->setFrom(MAIL_FROM_ADDRESS, 'pda-dcc.com');
        $mail->addAddress($data['receiver_email'], 'PDA-DCC member');

        //Content
        $email_template = APPROOT . '/views/inc/templateEmailAndPassword.php';
        $password = $data['password'];
        $verify_url = URLROOT . '/users/handleEmailConfirmation?type=' . $data['email_confirmation_type'] . '&newEmail=' . $data['receiver_email'] . '&id=' . $unverifiedUser->id . '&vkey=' . $unverifiedUser->account_registration_vkey;
        $about_url = URLROOT . '/about';
        $privacy_url = URLROOT . '/about/privacy';
        $terms_url = URLROOT . '/about/terms';
        $subject = 'PDA-DCC ' . str_replace('_', ' ', $data['email_confirmation_type']) . ' VERIFICATION';

        //message html templating
        $message = file_get_contents($email_template);
        $message = str_replace('{{verify_url}}', $verify_url, $message);
        $message = str_replace('{{password}}', $password, $message);
        $message = str_replace('{{about_url}}', $about_url, $message);
        $message = str_replace('{{privacy_url}}', $privacy_url, $message);
        $message = str_replace('{{terms_url}}', $terms_url, $message);
        $mail->isHTML(true);

        //set subject and message
        $mail->Subject = $subject;
        $mail->MsgHTML($message);

        $mail->send();
        $this->view('users/redirectPage', $data = ['message' => 'A confirmation link and password was just sent to ' . $data['receiver_email'] . '. The changes will take effect after you have clicked the link.', 'email' => $data['receiver_email']]);
      } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
      }
    }
  }


  public function report()
  {
    // die(var_dump($members));
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $data = [
        'current_route' => __FUNCTION__,

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
          redirect('licenseInfo');
        } else {
          die('Something went wrong');
        }
      } else {
        // Load view with errors
        $this->view('admins/report', $data);
      }
    } else {
      $user = $this->userModel->getUserById($_SESSION['user_id']);
      $amounts = $this->duesModel->getTotalAmountBetweenYears('2019', '2021');
      $data = [
        'current_route' => __FUNCTION__,
        'amounts' => $amounts,
        'dates' => generateYearsBetween(),

        'prc_number' => $user->prc_number,

        'prc_number_err' => '',
      ];

      $this->view('admins/report', $data);
    }
  }

  public function filterData()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);      
      $amounts = $this->duesModel->getTotalAmountBetweenYears($_POST['startYear'], $_POST['endYear']);
      echo json_encode(['data' => $amounts, 'status' => 'ok', 'code' => 200, 'message' => 'request successful']);
    }
  }
}
