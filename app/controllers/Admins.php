<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
    $this->activityModel = $this->model('Activity');
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
    $accounts = $this->userModel->getAllUserClinic();

    $data = [
      'current_route' => __FUNCTION__,

      'accounts' => $accounts,
    ];

    $this->view('admins/accounts', $data);
  }
  // public function accountsDatatable()
  // {
  //   try {
  //     if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  //       throw new Error('Your request method must be in \'POST\'');
  //     }

  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

  //     $draw = $_POST['draw'];
  //     $row = $_POST['start'];
  //     $rowperpage = $_POST['length'];
  //     $columnIndex = $_POST['order'][0]['column'];
  //     $columnName = $_POST['columns'][$columnIndex]['data'];
  //     $columnSortOrder = $_POST['order'][0]['dir'];
  //     $searchValue = $_POST['search']['value'];

  //     // custom filters
  //     // $memberType = $_POST['memberType'];
  //     // $role = $_POST['role'];

  //     // initialize search filter
  //     $searchQuery = " ";
  //     // if ($role != '') {
  //     //   $searchQuery .= " and (dues.type like '%" . $role . "%') ";
  //     // }

  //     // if ($memberType != '') {
  //     //   if (trim($memberType, ' ') == 'active') {
  //     //     $memberType = 1;
  //     //   } elseif (trim($memberType, ' ') == 'inactive') {
  //     //     $memberType = 0;
  //     //   }


  //     //   $searchQuery .= " and (users.is_active = " . $memberType . " ) ";
  //     // }

  //     if ($searchValue != '') {
  //       $searchQuery .= " and (date_created like '%" . $searchValue . "%' OR 
  //         type like '%" . $searchValue . "%' OR 
  //         first_name like '%" . $searchValue . "%' OR 
  //         last_name like '%" . $searchValue . "%' OR 
  //         channel like '%" . $searchValue . "%' OR 
  //         or_number like '%" . $searchValue . "%' ) ";
  //     }

  //     // initilize columns to be selected
  //     $selectables = [];
  //     foreach ($_POST['columns'] as $column) {
  //       // $selectables[] = $column['data'];
  //       $selectables[] = 'users.*';
  //       $selectables[] = 'clinics.*';
  //     }

  //     // Row count without filtering
  //     $totalRecords = $this->userModel->countAll()->count;

  //     // Row count with filtering
  //     $totalRecordwithFilter = $this->userModel->countAllWithFilters($searchQuery)->count;

  //     // Fetch records
  //     $empRecords = $this->userModel->getDatatable($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
  //     $data = array();

  //     foreach ($empRecords as $row) {
  //       $data[] = array(
  //         "timestamp" => $row->date_created,
  //         "name" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name),
  //         "role" => $row->amount,
  //         "memberType" => $row->is_active ? 'active' : 'inactive',
  //         "statusRemarks" => $row->is_active ? 'active' : 'inactive',
  //         "more" => '...',
  //         "email" => $row->channel,
  //         "prcNumber" => $row->or_number,
  //         "prcRegistrationDAte" => $row->user_id,
  //         "prcExpirationDate" => $row->channel,
  //         "practiceField" => $row->or_number,
  //         "practiceType" => $row->user_id,
  //         "birthdate" => $row->or_number,
  //         "gender" => $row->user_id,
  //         "contact" => $row->channel,
  //         "facebookAccount" => $row->or_number,
  //         "address" => $row->user_id,
  //         "clinicName" => $row->user_id,
  //         "clinicStreet" => $row->channel,
  //         "clinicDistrict" => $row->or_number,
  //         "clinicMunicipality" => $row->user_id,
  //         "clinicContact" => $row->or_number,
  //         "emergencyPerson" => $row->user_id,
  //         "emergencyPersonAddress" => $row->channel,
  //         "emergencyPersonContact" => $row->or_number
  //       );
  //     }

  //     $response = array(
  //       "draw" => intval($draw),
  //       "iTotalRecords" => $totalRecords,
  //       "iTotalDisplayRecords" => $totalRecordwithFilter,
  //       "aaData" => $data
  //     );
  //     $response['status'] = 'ok';
  //     $response['message'] = 'records were successfully fetched';
  //     header("Content-Type: application/json; charset=UTF-8");

  //     exit(json_encode($response));
  //   } catch (\Throwable $th) {
  //     $response['status'] = 'fail';
  //     $response['message'] = $th->getMessage();

  //     header("Content-Type: application/json; charset=UTF-8");

  //     exit(json_encode($response));
  //   }
  // }

  public function memberList()
  {
    $accounts = $this->userModel->getAllUserClinic();

    $data = [
      'current_route' => __FUNCTION__,

      'accounts' => $accounts,
    ];

    $this->view('admins/memberList', $data);
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
      $amounts = $this->duesModel->getTotalAmountBetweenYears(date('Y'), date('Y') + 1);
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
  public function reportsDatatable()
  {
    try {
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Error('Your request method must be in \'POST\'');
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length'];
      $columnIndex = $_POST['order'][0]['column'];
      $columnName = $_POST['columns'][$columnIndex]['data'];
      $columnSortOrder = $_POST['order'][0]['dir'];
      $searchValue = $_POST['search']['value'];

      // custom filters
      $startMonth = $_POST['startMonth'];
      $endMonth = $_POST['endMonth'];
      $startYear = $_POST['startYear'];
      $endYear = $_POST['endYear'];

      $memberType = $_POST['memberType'];
      $paymentType = $_POST['paymentType'];

      // initialize search filter
      $searchQuery = " ";
      if ($startMonth != '' && $endMonth != '' && $startYear != '' &&  $endYear != '') {
        $searchQuery .= " and (date_created BETWEEN CONCAT('" . $startYear . "','-','" . $startMonth . "','-01') AND CONCAT('" . $endYear . "','-','" . $endMonth . "','-01')) ";
      }

      if ($paymentType != '') {
        $searchQuery .= " and (dues.type like '%" . $paymentType . "%') ";
      }

      if ($memberType != '') {
        if (trim($memberType, ' ') == 'active') {
          $memberType = 1;
        } elseif (trim($memberType, ' ') == 'inactive') {
          $memberType = 0;
        }


        $searchQuery .= " and (users.is_active = " . $memberType . " ) ";
      }

      if ($searchValue != '') {
        $searchQuery .= " and (date_created like '%" . $searchValue . "%' OR 
          type like '%" . $searchValue . "%' OR 
          first_name like '%" . $searchValue . "%' OR 
          last_name like '%" . $searchValue . "%' OR 
          channel like '%" . $searchValue . "%' OR 
          or_number like '%" . $searchValue . "%' ) ";
      }

      // initilize columns to be selected
      $selectables = [];
      foreach ($_POST['columns'] as $column) {
        $selectables[] = $column['data'];
        $selectables[] = 'users.*';
        $selectables[] = 'dues.*';
      }

      // Row count without filtering
      $totalRecords = $this->duesModel->countAll()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->duesModel->countAllWithFilters($searchQuery)->count;

      // Fetch records
      $empRecords = $this->duesModel->getDatatable($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      foreach ($empRecords as $row) {
        $data[] = array(
          "date_created" => $row->date_created,
          "first_name" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name),
          "amount" => $row->amount,
          "is_active" => $row->is_active ? 'active' : 'inactive',
          "type" => $row->type,
          "channel" => $row->channel,
          "or_number" => $row->or_number,
          "user_id" => $row->user_id,
        );
      }

      $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
      );
      $response['status'] = 'ok';
      $response['message'] = 'records were successfully fetched';
      header("Content-Type: application/json; charset=UTF-8");

      exit(json_encode($response));
    } catch (\Throwable $th) {
      $response['status'] = 'fail';
      $response['message'] = $th->getMessage();

      header("Content-Type: application/json; charset=UTF-8");

      exit(json_encode($response));
    }
  }

  public function addPayment()
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

      $decoded['message'] = 'New payment were successfully added!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['paymentForm']['user_id'])) {
        $decoded['errors']['user_id_err'] = 'Your prc number must not be empty';
      }

      if (empty($decoded['paymentForm']['type'])) {
        $decoded['errors']['type_err'] = 'Please select a payment type';
      }

      if (empty($decoded['paymentForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'Please enter an amount';
      } else if (!is_numeric($decoded['paymentForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'Please enter a valid amount';
      }

      if (empty($decoded['paymentForm']['channel'])) {
        $decoded['errors']['channel_err'] = 'Please enter a payment channel';
      }

      if (empty($decoded['paymentForm']['or_number'])) {
        $decoded['errors']['or_number_err'] = 'Please enter the OR number';
      }

      if (empty($decoded['paymentForm']['date'])) {
        $decoded['errors']['date_err'] = 'Please enter a valid date';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      // check if payment insert is unsuccessful or prc number does not exist
      if (!$this->duesModel->store($decoded['paymentForm'])) {
        throw new Error('prc_number: ' . $decoded['paymentForm']['user_id'] . ' is not correct or non existing. Try again');
      }

      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' registered an amount of ' . $decoded['paymentForm']['amount'] . ' as dues payment to ' . $decoded['paymentForm']['type'] . ' with an OR No. of ' . $decoded['paymentForm']['or_number'],
            'type' => 'add_payment',
          ]
        );
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
  public function importPayment()
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

      $content = trim(file_get_contents("php://input"));
      $decoded = json_decode($content, true);

      $decoded['message'] = 'New payment were successfully added!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      if (!isset($_FILES["imported_payments"]['name'])) {
        throw new Error('You must import a file to proceed.');
      }

      $allowFileExtensions = [
        'xls',
        'xlsx',
        'csv'
      ];
      $file_array = explode(".", $_FILES["imported_payments"]["name"]);
      $file_extension = end($file_array);

      if (!in_array($file_extension, $allowFileExtensions)) {
        throw new Error('The file format of the file you imported is not valid. You must follow these following formats (.csv, .xls and .xlsx)');
      }

      $file_name = 'PDA-DCC-dues-' . time() . '.' . $file_extension;
      move_uploaded_file($_FILES['imported_payments']['tmp_name'], $file_name);
      $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

      $spreadsheet = $reader->load($file_name);

      unlink($file_name);

      $data = $spreadsheet->getActiveSheet()->toArray();

      if (sizeof($data) == 1) {
        throw new Error('You imported 0 rows. You need to populate the necessary cells or rows. Try again');
      }

      $index = 0;
      foreach ($data as $row) {
        if ($index == 0) {
          // check if the column headers are in the correct position
          if (empty($row[0]) && empty($row[1]) && empty($row[2]) && empty($row[3]) && empty($row[4]) && empty($row[5]) && empty($row[6])) {
            throw new Error('The column headers are missing or incorrectly positioned. The column headers should be placed on top of the column items at the very first row of the spreadsheet or in cells (A1, B1, up to G1).');
          }

          // check for the correct column headers
          if ($row[0] != 'prc_number') {
            throw new Error('\'' . $row[0] . '\'' . ' is not a correct column header for the first column, \'prc_number\' is the correct one. Try again');
          } else if ($row[1] != 'type') {
            throw new Error('\'' . $row[1] . '\'' . ' is not a correct column header for the second column, \'type\' is the correct one. Try again');
          } else if ($row[2] != 'amount') {
            throw new Error('\'' . $row[2] . '\'' . ' is not a correct column header for the third column, \'amount\' is the correct one. Try again');
          } else if ($row[3] != 'channel') {
            throw new Error('\'' . $row[3] . '\'' . ' is not a correct column header for the fourth column, \'channel\' is the correct one. Try again');
          } else if ($row[4] != 'or_number') {
            throw new Error('\'' . $row[4] . '\'' . ' is not a correct column header for the fifth column, \'or_number\' is the correct one. Try again');
          } else if ($row[5] != 'remarks') {
            throw new Error('\'' . $row[5] . '\'' . ' is not a correct column header for the sixth column, \'remarks\' is the correct one. Try again');
          } else if ($row[6] != 'date') {
            throw new Error('\'' . $row[6] . '\'' . ' is not a correct column header for the seventh column, \'date\' is the correct one. Try again');
          }
        } else {
          // check for empty cells except 'remarks'
          if (empty($row[0])) {
            throw new Error('\'row ' . $index . '\' on column \'prc_number\' should not be empty. Try again');
          } else if (empty($row[1])) {
            throw new Error('\'row ' . $index . '\' on column \'type\' should not be empty. Try again');
          } else if (empty($row[2])) {
            throw new Error('\'row ' . $index . '\' on column \'amount\' should not be empty. Try again');
          } else if (empty($row[3])) {
            throw new Error('\'row ' . $index . '\' on column \'channel\' should not be empty. Try again');
          } else if (empty($row[4])) {
            throw new Error('\'row ' . $index . '\' on column \'or_number\' should not be empty. Try again');
          } else if (empty($row[6])) {
            throw new Error('\'row ' . $index . '\' on column \'date\' should not be empty. Try again');
          }

          // check if the input type is not valid
          if (!in_array(strtolower($row[1]), ['pda', 'dcc'])) {
            throw new Error($row[1] . ' is not a valid cell value for column \'type\'. It should either be (pda and dcc or PDA and DCC). Try again');
          }

          if (!is_numeric($row[2])) {
            throw new Error($row[1] . ' is not a valid numeric value for the cell \'amount\'. It should be numeric to be considered as money. Try again');
          }

          if (!strtotime($row[6])) {
            throw new Error($row[6] . ' is not a valid date value for the cell \'date\'. It should be a date formatted in (MM/DD/YYYY). Try again');
          }

          $day = date('d', strtotime($row[6]));
          $month = date('m', strtotime($row[6]));
          $year = date('Y', strtotime($row[6]));
          if (!checkdate($month, $day, $year)) {
            throw new Error($row[6] . ' is not a valid date value for the cell \'date\'. It should have a correct Month, Day, and Year values. Try again');
          }

          // check for the correct/existing prc_number values
          if (!$this->userModel->haveRows(['prc_number'], [$row[0]])) {
            throw new Error('prc_number: ' . $row[0] . ' does not exist. Try again');
          }
        }

        $index++;
      }

      $index2 = 0;
      foreach ($data as $row) {
        if ($index != 0) {
          $row[6] = date('Y-m-d', strtotime($row[6])); // change format so that mysql accepts date

          $this->duesModel->storeByPrcNumber($row);
        }
        $index2++;
      }

      $spreadsheetRowCount = sizeof($data);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' imported ' . $spreadsheetRowCount . ' payments.',
            'type' => 'add_payment',
          ]
        );
      }

      $reply = json_encode($decoded);

      header("Content-Type: application/json; charset=UTF-8");
      exit($reply);
    } catch (\Throwable $th) {
      header("Content-Type: application/json; charset=UTF-8");
      $decoded['status'] = 'fail';
      $decoded['message'] = $th->getMessage();
      $reply = json_encode($decoded);

      exit($reply);
    }
  }
  public function activities()
  {
    $user = $this->userModel->getUserById($_SESSION['user_id']);
    $activities = $this->activityModel->getAll();
    $data = [
      'current_route' => __FUNCTION__,

      'activities' => $activities,
    ];

    $this->view('admins/activities', $data);
  }

  public function activitiesDatatable()
  {
    try {
      if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Error('Your request method must be in \'POST\'');
      }

      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

      $draw = $_POST['draw'];
      $row = $_POST['start'];
      $rowperpage = $_POST['length'];
      $columnIndex = $_POST['order'][0]['column'];
      $columnName = $_POST['columns'][$columnIndex]['data'];
      $columnSortOrder = $_POST['order'][0]['dir'];
      $searchValue = $_POST['search']['value'];

      // initilize columns to be selected
      $selectables = [];
      foreach ($_POST['columns'] as $column) {
        $selectables[] = $column['data'];
      }

      // initialize search filter
      $searchQuery = " ";
      if ($searchValue != '') {
        $searchQuery = " and (created_at like '%" . $searchValue . "%' OR 
          initiator like '%" . $searchValue . "%' OR 
          type like'%" . $searchValue . "%' ) ";
      }

      // Row count without filtering
      $totalRecords = $this->activityModel->count();

      // Row count with filtering
      $totalRecordwithFilter = $this->activityModel->count($searchQuery);

      // Fetch records
      $empRecords = $this->activityModel->selectAll($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      foreach ($empRecords as $row) {
        $data[] = array(
          "created_at" => $row->created_at,
          "initiator" => $row->initiator,
          "type" => $row->type,
          "message" => $row->message
        );
      }

      $response = array(
        "draw" => intval($draw),
        "iTotalRecords" => $totalRecords,
        "iTotalDisplayRecords" => $totalRecordwithFilter,
        "aaData" => $data
      );
      $response['status'] = 'ok';
      $response['message'] = 'records were successfully fetched';
      header("Content-Type: application/json; charset=UTF-8");

      exit(json_encode($response));
    } catch (\Throwable $th) {
      $response['status'] = 'fail';
      $response['message'] = $th->getMessage();

      header("Content-Type: application/json; charset=UTF-8");

      exit(json_encode($response));
    }
  }

  public function userStatusChange()
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

      $decoded['message'] = 'User status was successfully updated!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['setStatus']['user_id'])) {
        $decoded['errors']['user_id_err'] = 'The account\'s user id must not be empty';
      }

      $reply = json_encode($decoded);

      $user = $this->userModel->getUserById($decoded['setStatus']['user_id']);

      // check user status
      $statusValue = false;
      $statusValueLabel = 'deactivated';
      if (!$user->is_active) {
        $statusValue = true;
        $statusValueLabel = 'activated';
      }
      if ($decoded['setStatus']['updateRemarks'] == true) {
        $statusValue = false;
        $statusValueLabel = 'updated remarks';
      }

      // check if user status was not successfully updated
      if (!$this->userModel->update2(
        ['status_remarks', 'is_active'],
        [$decoded['setStatus']['remarks'], $statusValue],
        'id',
        $decoded['setStatus']['user_id']
      )) {
        throw new Error('user_id: ' . $decoded['setStatus']['user_id'] . ' is not correct or non existing. Try again');
      }

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' ' . $statusValueLabel . ' ' . $userFullname,
            'type' => 'change_status',
          ]
        );
      }

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
  public function reassignAdminRole()
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

      $decoded['message'] = 'User status was successfully updated!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['user_id'])) {
        $decoded['errors']['user_id_err'] = 'The account\'s user id must not be empty';
      }

      $user = $this->userModel->getUserById($decoded['user_id']);

      // check user status
      $role = '';
      if ($this->isAdmin($user->role)) {
        $role = $this->ROLE_MEMBER;
      }
      if ($this->isMember($user->role)) {
        $role = $this->ROLE_ADMIN;
      }

      // check if user status was not successfully updated
      if (!$this->userModel->update2(
        ['role'],
        [$role],
        'id',
        $decoded['user_id']
      )) {
        throw new Error('user_id: ' . $decoded['user_id'] . ' is not correct or non existing. Try again');
      }
      $reply = json_encode($decoded);

      header("Content-Type: application/json; charset=UTF-8");
      exit($reply);
    } catch (\Throwable $th) {
      header("Content-Type: application/json; charset=UTF-8");
      $decoded['status'] = 'fail';
      $decoded['message'] = $th->getMessage();
      $reply = json_encode($decoded);

      exit($reply);
    }
  }

  public function filterData()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $amounts = $this->duesModel->getTotalAmountBetweenYears($_POST['startYear'], $_POST['endYear'], $_POST['startMonth'], $_POST['endMonth']);

      exit(json_encode(['data' => $amounts, 'status' => 'ok', 'code' => 200, 'message' => 'request successful']));
    }
  }

  public function paymentBreakdown()
  {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      $amountsPDA = $this->duesModel->getPaymentsByUserAndType($_POST['user_id'], 'PDA', $_POST['startYear'], $_POST['endYear']);
      $amountsDCC = $this->duesModel->getPaymentsByUserAndType($_POST['user_id'], 'DCC', $_POST['startYear'], $_POST['endYear']);

      exit(json_encode(
        [
          'data' => ['pda' => $amountsPDA, 'dcc' => $amountsDCC], 'status' => 'ok', 'code' => 200, 'message' => 'request successful'
        ]
      ));
    }
  }


  public function viewAccount()
  {
    $userId = $_GET['id'];

    $params = ['id' => $userId, 'idType' => 'id'];
    $user = $this->userModel->getUserClinic($params);
    $paymentHistory = $this->duesModel->getUserYearlyPayments(['user_id' => 2]);

    $data = [
      'user' => $user,
      'current_route' => __FUNCTION__,

      'paymentHistory' => $paymentHistory,
      'years' => generateYearsBetween()
    ];

    $this->view('admins/viewAccount', $data);
  }

  /* UPDATE USER INFORMATION */
  public function updateProfile()
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

      $decoded['message'] = 'Profile was successfully updated!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['profile']['email'])) {
        $decoded['errors']['email_err'] = 'Your email should not be empty';
      } else {
        if (!filter_var($decoded['profile']['email'], FILTER_VALIDATE_EMAIL)) {
          $decoded['errors']['email_err'] = 'Please enter a valid email';
        }

        if ($this->userModel->findUserByEmail($decoded['profile']['email'])) {
          $decoded['errors']['email_err'] = 'Email is already taken';
        }
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      // check if payment insert is unsuccessful or prc number does not exist
      if (!$this->userModel->update2(
        ['email'],
        [$decoded['profile']['email']],
        'id',
        $decoded['profile']['user_id']
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->userModel->getUserById($decoded['profile']['user_id']);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' updated the profile of ' . $userFullname,
            'type' => 'update_user',
          ]
        );
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
      if (!$this->userModel->update2(
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
        'id',
        $decoded['personal']['user_id']
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->userModel->getUserById($decoded['personal']['user_id']);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' updated the personal info of ' . $userFullname,
            'type' => 'update_user',
          ]
        );
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
      if (!$this->userModel->update2(
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
        'id',
        $decoded['license']['user_id']
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->userModel->getUserById($decoded['license']['user_id']);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' updated the license info of ' . $userFullname,
            'type' => 'update_user',
          ]
        );
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
      if (!$this->clinicModel->update2(
        [
          'name',
          'street',
          'district',
          'city',
          'contact_number'
        ],
        [
          $decoded['clinic']['clinic_name'],
          $decoded['clinic']['clinic_street'],
          $decoded['clinic']['clinic_district'],
          $decoded['clinic']['clinic_city'],
          $decoded['clinic']['clinic_contact_number']
        ],
        'user_id',
        $decoded['clinic']['user_id']
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->userModel->getUserById($decoded['clinic']['user_id']);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' updated the clinic info of ' . $userFullname,
            'type' => 'update_user',
          ]
        );
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
      if (!$this->userModel->update2(
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
        'id',
        $decoded['emergency']['user_id']
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->userModel->getUserById($decoded['emergency']['user_id']);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($_SESSION['role'] == 'admin') {
        $this->activityModel->store(
          [
            'user_id' => $_SESSION['user_id'],
            'initiator' => $_SESSION['user_name'],
            'message' => 'Admin: ' . $_SESSION['user_name'] . ' updated the emergency info of ' . $userFullname,
            'type' => 'update_user',
          ]
        );
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
}
