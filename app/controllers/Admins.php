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
    $this->userModel = $this->model('User');
    $this->clinicModel = $this->model('Clinic');
    $this->duesModel = $this->model('Dues');
    $this->activityModel = $this->model('Activity');
    $this->profileModel = $this->model('Profile');

    parent::__construct();

    $this->session->start();

    if (!$this->isLoggedin() || !$this->isEmailVerified()) {
      $this->url->redirectToLoginpage();
    }

    if ($this->isLoggedIn() && !$this->isCompleteInfo() && $this->isPasswordRegistered()) {
      $this->url->redirect('users/registerPrcInfo');
    }

    if ($this->role->isMember($this->session->get(SessionManager::SESSION_USER)->role)) {
      $this->url->redirect('profiles/userInfo');
    }

    $this->currentUserFullname = arrangeFullname(
      $this->session->get(SessionManager::SESSION_USER)->first_name,
      $this->session->get(SessionManager::SESSION_USER)->middle_name,
      $this->session->get(SessionManager::SESSION_USER)->last_name
    );
  }

  public function index()
  {
    $data = [
      'current_route' => __FUNCTION__,

      'posts' => 'dogger'
    ];

    $this->view('admins/paymentHistory', $data);
  }

  public function duesForm()
  {
    $data = [
      'current_route' => __FUNCTION__,
    ];

    $this->view('admins/duesForm', $data);
  }

  public function addDues()
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

      $decoded['message'] = 'New dues was successfully added!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['duesForm']['prc_number'])) {
        $decoded['errors']['prc_number_err'] = 'Prc number must not be empty';
      }

      if (empty($decoded['duesForm']['type'])) {
        $decoded['errors']['type_err'] = 'Please select a payment type';
      }

      if (empty($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'Please enter an amount';
      } else if (!is_numeric($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'Please enter a valid amount';
      }

      if (empty($decoded['duesForm']['channel'])) {
        $decoded['errors']['channel_err'] = 'Please enter a payment channel';
      }

      if (empty($decoded['duesForm']['or_number'])) {
        $decoded['errors']['or_number_err'] = 'Please enter the OR number';
      }

      if (empty($decoded['duesForm']['date_posted']['month'])) {
        $decoded['errors']['date_posted_err'] = 'Month must not be empty';
      }
      if ($decoded['duesForm']['date_posted']['month'] > 12 || $decoded['duesForm']['date_posted']['month'] < 1) {
        $decoded['errors']['date_posted_err'] = 'Please enter a valid month';
      }
      if (empty($decoded['duesForm']['date_posted']['year'])) {
        $decoded['errors']['date_posted_err'] = 'year must not be empty';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      // concat month, year plus imaginary day to create a valid date for mysql
      $decoded['duesForm']['date_posted'] = $decoded['duesForm']['date_posted']['year'] . '-' . $decoded['duesForm']['date_posted']['month'] . '-01';

      // uppercase strings
      $decoded['duesForm']['type'] = strtoupper($decoded['duesForm']['type']);

      if ($this->profileModel->hasRow(['prc_number'], [$decoded['duesForm']['prc_number']]) === false) {
        $decoded['errors']['prc_number_err'] = 'The prc number: ' . $decoded['duesForm']['prc_number'] . ' does not have a linked profile. Try again.';
        throw new Error('prc number is non-existing');
      }

      $profile =  $this->profileModel->find(
        ['*'],
        ['prc_number'],
        [$decoded['duesForm']['prc_number']]
      );
      $decoded['duesForm']['profile_id'] = $profile->id;

      // check if payment insert is unsuccessful or prc number does not exist
      $last_record = $this->duesModel->store($decoded['duesForm']);
      if (!$last_record) {
        throw new Error('Something went wrong with the storing of dues. Try again');
      }

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' registered an amount of ' . $last_record->amount . ' as dues payment to ' . $last_record->type . ' (' . date('Y', strtotime($last_record->date_posted)) . ') with an OR No. of ' . $last_record->or_number . ' and row no. of ' . $last_record->id,
            'type' => 'add_dues',
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

  public function importDues()
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

      $decoded['message'] = 'New profile(s) were successfully added!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      if (!isset($_FILES["dues_file"]['name'])) {
        throw new Error('You must import a file to proceed.');
      }

      $allowFileExtensions = [
        'xls',
        'xlsx',
        'csv'
      ];
      $file_array = explode(".", $_FILES["dues_file"]["name"]);
      $file_extension = end($file_array);

      if (!in_array($file_extension, $allowFileExtensions)) {
        throw new Error('The file format of the file you imported is not valid. You must follow these following formats (.csv, .xls and .xlsx)');
      }

      $file_name = 'PDA-DCC-dues-' . time() . '.' . $file_extension;
      move_uploaded_file($_FILES['dues_file']['tmp_name'], $file_name);
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
        $row['prc_number'] = trim($row[0]);
        $row['amount'] = trim($row[1]);
        $row['paid_to'] = trim($row[2]);
        $row['channel'] = trim($row[3]);
        $row['or_number'] = trim($row[4]);
        $row['date_posted'] = trim($row[5]);
        $row['remarks'] = trim($row[6]);

        if ($index > 0) {
          // ignore row if all cells are empty
          if (
            empty($row['prc_number'])
            && empty($row['amount'])
            && empty($row['paid_to'])
            && empty($row['channel'])
            && empty($row['or_number'])
            && empty($row['date_posted'])
            && empty($row['remarks'])
          ) {
            continue;
          }

          if (empty($row['prc_number'])) {
            throw new Error('\'row ' . $index . '\' on column \'PRC No.\' should not be empty. Try again');
          } else if (empty($row['amount'])) {
            throw new Error('\'row ' . $index . '\' on column \'AMOUNT\' should not be empty. Try again');
          } else if (empty($row['paid_to'])) {
            throw new Error('\'row ' . $index . '\' on column \'PAID TO (PDA/DCC)\' should not be empty. Try again');
          } else if (empty($row['channel'])) {
            throw new Error('\'row ' . $index . '\' on column \'PAYMENT CHANNEL\' should not be empty. Try again');
          } else if (empty($row['or_number'])) {
            throw new Error('\'row ' . $index . '\' on column \'OR NO.\' should not be empty. Try again');
          } else if (empty($row['date_posted'])) {
            throw new Error('\'row ' . $index . '\' on column \'DATE POSTED \' should not be empty. Try again');
          }

          // check if the input type is not valid
          if (!in_array(strtolower($row['paid_to']), ['pda', 'dcc'])) {
            throw new Error($row['paid_to'] . ' is not a valid cell value for column \'type\'. It should either be (pda and dcc or PDA and DCC). Try again');
          }

          if (!is_numeric($row['amount'])) {
            throw new Error($row['amount'] . ' is not a valid numeric value for the cell \'amount\'. It should be numeric to be considered as money. Try again');
          }

          if (!strtotime($row['date_posted']) || strlen($row['date_posted']) <= 1) {
            throw new Error($row['date_posted'] . ' is not a valid date value for the cell \'DATE POSTED\'. It should be a date formatted in (MM/DD/YYYY). Try again');
          }

          $day = date('d', strtotime($row['date_posted']));
          $month = date('m', strtotime($row['date_posted']));
          $year = date('Y', strtotime($row['date_posted']));
          if (!checkdate($month, $day, $year)) {
            throw new Error($row['date_posted'] . ' is not a valid date value for the cell \'DATE POSTED\'. It should have a correct Month, Day, and Year values. Try again');
          }
        }

        $index++;
      }

      $insertedRows = array();
      $insertedRowInfos = array();
      $index2 = 0;
      foreach ($data as $row) {
        if ($index2 > 0) {
          // ignore row if all cells are empty
          if (
            empty(trim($row[0]))
            && empty(trim($row[1]))
            && empty(trim($row[2]))
            && empty(trim($row[3]))
            && empty(trim($row[4]))
            && empty(trim($row[5]))
            && empty(trim($row[6]))
          ) {
            continue;
          }

          $row[2] = strtoupper(trim($row[2]));
          $row[5] = date('Y-m-d', strtotime(trim($row[5]))); // change format so that mysql accepts date
          $row['profile_id'] = null;
          $row['profile_name'] = null;

          if (!$this->profileModel->hasRow(['prc_number'], [trim($row[0])])) {
            throw new Error('The PRC No.: ' . trim($row[0]) . ' on row ' . $index2 . ' does not have a linked profile. Try again.');
          }

          $profile =  $this->profileModel->find(
            ['*'],
            ['prc_number'],
            [trim($row[0])]
          );

          $row['profile_id'] = $profile->id;
          $row['profile_name'] = arrangeFullname($profile->first_name, $profile->middle_name, $profile->last_name);

          $last_row = $this->duesModel->store2($row);

          $last_row->profile_id = !empty($last_row->profile_id) ? 'Linked (' . $row["profile_name"] . ')' : 'No links';
          $insertedRows[] = $last_row; // returns the last row
          $insertedRowInfos[] = $last_row->type . ' - ' . date('Y', strtotime($last_row->date_posted)) . ' (#' . $last_row->or_number . ')';
        }
        $index2++;
      }



      $decoded['insertedRows'] = $insertedRows;
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' imported ' . count($insertedRows) . ' payments [' . join(', ', $insertedRowInfos) . ']',
            'type' => 'add_dues',
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

  public function dues()
  {
    $data = [
      'current_route' => __FUNCTION__,
      'dates' => generateYearsBetween(),
    ];

    $this->view('admins/dues', $data);
  }

  public function duesDatatable()
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

      // $memberType = $_POST['memberType'];
      // $paymentType = $_POST['paymentType'];

      // initialize search filter
      $searchQuery = " ";
      if ($startMonth != '' && $endMonth != '' && $startYear != '' &&  $endYear != '') {
        $searchQuery .= " and (date_posted BETWEEN CONCAT('" . $startYear . "','-','" . $startMonth . "','-01') AND CONCAT('" . $endYear . "','-','" . $endMonth . "','-01')) ";
      }

      // if ($paymentType != '') {
      //   $searchQuery .= " and (dues.type like '%" . $paymentType . "%') ";
      // }

      // if ($memberType != '') {
      //   if (trim($memberType, ' ') == 'active') {
      //     $memberType = 1;
      //   } elseif (trim($memberType, ' ') == 'inactive') {
      //     $memberType = 0;
      //   }


      //   $searchQuery .= " and (users.is_active = " . $memberType . " ) ";
      // }

      if ($searchValue != '') {
        $searchQuery .= " and (date_added like '%" . $searchValue . "%' OR 
          type like '%" . $searchValue . "%' OR 
          first_name like '%" . $searchValue . "%' OR 
          last_name like '%" . $searchValue . "%' OR 
          channel like '%" . $searchValue . "%' OR 
          or_number like '%" . $searchValue . "%' ) ";
      }

      // initilize columns to be selected
      $selectables = [];
      foreach ($_POST['columns'] as $column) {
        // $selectables[] = $column['data'];
        $selectables[] = 'profiles.*';
        $selectables[] = 'dues22.*';
        $selectables[] = '(SELECT SUM(dues22.amount) FROM dues22) AS total_amount';
      }

      // Row count without filtering
      $totalRecords = $this->duesModel->countAll2()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->duesModel->countAllWithFilters2($searchQuery)->count;

      // Fetch records
      $empRecords = $this->duesModel->getDatatable2($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      foreach ($empRecords as $row) {
        $data[] = array(
          "date_posted" => date('Y-M', strtotime($row->date_posted)),
          "first_name" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name) ?? '',
          "amount" => $row->amount,
          "payment_status" => $row->payment_status,
          "type" => $row->type,
          "channel" => $row->channel,
          "or_number" => $row->or_number,
          'user_id' => $row->profile_id,
          'total_amount' => $row->total_amount
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

  public function users()
  {
    $data = [
      'current_route' => __FUNCTION__,
      'dates' => generateYearsBetween(),
    ];

    $this->view('admins/users', $data);
  }
  public function usersDatatable()
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
      $accountStatus = $_POST['accountStatus'];
      $role = $_POST['role'];

      // initialize search filter
      $searchQuery = " AND role != 'superadmin'";
      if ($searchValue != '') {
        $searchQuery .= " and ( account_status = '" . $searchValue . "') ";
      }

      if ($role != '') {
        $searchQuery .= " and ( role = '" . $role . "') ";
      }

      if ($accountStatus != '') {
        $searchQuery .= " and ( account_status = '" . $accountStatus . "') ";
      }

      // initilize columns to be selected
      $selectables = [];
      $selectables[] = 'accounts.*';

      // Row count without filtering
      $totalRecords = $this->userModel->countAll2()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->userModel->countAllWithFilters2($searchQuery)->count;

      // Fetch records
      $empRecords = $this->userModel->getDatatable2($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      foreach ($empRecords as $row) {
        $today = date('Y-m-d');
        $lastLogDate = date('Y-m-d', strtotime($row->logged_at));
        $dateInSixMonthsSinceLastLog = date('Y-m-d', strtotime($lastLogDate . ' + 6 months'));

        $data[] = array(
          "profile_img_path" => $row->profile_img_path,
          "thumbnail_img_path" => $row->thumbnail_img_path,
          "created_at" => $row->created_at,
          "email" => $row->email,
          "role" => $row->role,
          "account_status" => $dateInSixMonthsSinceLastLog <= $today ? 'inactive' : 'active',
          "logged_at" => $row->logged_at,

          "user_id" => $row->id,
        );
      }

      //  $currentDate = 

      //   dd(date('Y-m-d', strtotime(date('Y-m-d'). ' + 6 months')));



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

  public function profiles()
  {
    $data = [
      'current_route' => __FUNCTION__,
      'dates' => generateYearsBetween(),
    ];

    $this->view('admins/profiles', $data);
  }

  public function profilesDatatable()
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
      $paymentStatus = $_POST['status'];

      // initialize search filter
      $searchQuery = "";
      if ($searchValue != '') {
        $searchQuery .= " and ( CONCAT(first_name, ' ', SUBSTR(middle_name, 1, 1), ' ', last_name) LIKE '%" . $searchValue . "%' OR
          CONCAT(last_name, ' ', first_name, ' ', middle_name) LIKE '%" . $searchValue . "%' OR
          prc_number LIKE '%" . $searchValue . "%') ";
      }

      if ($paymentStatus != '') {
        $searchQuery .= " and (payment_status like '%" . $paymentStatus . "%') ";
      }

      // initilize columns to be selected
      $selectables = [];
      $selectables[] = 'GROUP_CONCAT(YEAR(cd_dues.cd_dates)) AS cd_dates';
      $selectables[] = 'GROUP_CONCAT(CONCAT(YEAR(cd_dues.cd_dates), IFNULL(CONCAT(" (#", or_number, ")" ), "")) SEPARATOR ", ") AS dcdc_dues';
      $selectables[] = 'profiles.*';

     
      // Row count without filtering
      $totalRecords = $this->profileModel->countAll2()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->profileModel->countAllWithFilters2($searchQuery)->count;

      // Fetch records
      $empRecords = $this->profileModel->getDatatable2($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      $lastThreeYears = [
        date('Y', strtotime(date('Y-m-d') . ' - 1 year')),
        date('Y', strtotime(date('Y-m-d') . ' - 2 year')),
        date('Y', strtotime(date('Y-m-d') . ' - 3 year')),
      ];
      foreach ($empRecords as $row) {
        $paymentDates = array_reverse(explode(',', $row->cd_dates));
        $firstYearOfPayment = $paymentDates[0];
        $missingYears = $this->getMissingYears($paymentDates, $firstYearOfPayment);
        $paymentStatus = '';

        if(empty($missingYears)) $paymentStatus = 'Complete Payment';
        else $paymentStatus = 'Incomplete Payment';
        if(empty($firstYearOfPayment)) $paymentStatus = '';
        if(
          in_array($lastThreeYears[0], $missingYears) &&
          in_array($lastThreeYears[1], $missingYears) &&
          in_array($lastThreeYears[2], $missingYears)
        ) $paymentStatus = 'Dormant';

        $data[] = array(
          "dcdc_dues" => $row->dcdc_dues,
          
          "prc_number" => $row->prc_number,
          "last_name" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name),
          "payment_status" => $paymentStatus,
          "status_remarks" => $row->status_remarks,
          "birthdate" => $row->birthdate,
          "address" => $row->address,
          "contact_number" => $row->contact_number,
          "gender" => $row->gender,
          "fb_account_name" => $row->fb_account_name,
          "prc_registration_date" => $row->prc_registration_date,
          "prc_expiration_date" => $row->prc_expiration_date,
          "field_practice" => $row->field_practice,
          "type_practice" => $row->type_practice,
          "clinic_name" => $row->clinic_name,
          "clinic_street" => $row->clinic_street,
          "clinic_district" => $row->clinic_district,
          "clinic_city" => $row->clinic_city,
          "clinic_contact" => $row->clinic_contact,
          "emergency_person_name" => $row->emergency_person_name,
          "emergency_address" => $row->emergency_address,
          "emergency_contact_number" => $row->emergency_contact_number,

          "profile_id" => $row->id,
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

  private function getMissingYears(array $years, $dateStart = '1981'): ?array
  {
    $missingYears = array();
    $dateStart .= '-01-01';
    $dateStart = date_create($dateStart);
    $years = array_map(fn ($y) => $y .= '-01-01', $years);

    $dateEnd   = date_create();
    $interval  = new DateInterval('P1Y');
    $period    = new DatePeriod($dateStart, $interval, $dateEnd);
    foreach ($period as $year) {
      $formatted = $year->format("Y-m-d");
      if (!in_array($formatted, $years)) $missingYears[] = date('Y', strtotime($formatted));
    }

    return $missingYears;
  }

  public function profileForm()
  {
    $data = [
      'current_route' => __FUNCTION__
    ];

    $this->view('admins/profileForm', $data);
  }

  public function importProfile()
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

      $decoded['message'] = 'New profile(s) were successfully added!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      if (!isset($_FILES["profile_file"]['name'])) {
        throw new Error('You must import a file to proceed.');
      }

      $allowFileExtensions = [
        'xls',
        'xlsx',
        'csv'
      ];
      $file_array = explode(".", $_FILES["profile_file"]["name"]);
      $file_extension = end($file_array);

      if (!in_array($file_extension, $allowFileExtensions)) {
        throw new Error('The file format of the file you imported is not valid. You must follow these following formats (.csv, .xls and .xlsx)');
      }

      $file_name = 'PDA-DCC-dues-' . time() . '.' . $file_extension;
      move_uploaded_file($_FILES['profile_file']['tmp_name'], $file_name);
      $file_type = \PhpOffice\PhpSpreadsheet\IOFactory::identify($file_name);
      $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($file_type);

      $spreadsheet = $reader->load($file_name);

      unlink($file_name);

      $data = $spreadsheet->getActiveSheet()->toArray();

      if (sizeof($data) == 1) {
        throw new Error('You imported 0 rows. You need to populate the necessary cells or rows. Try again');
      }

      $index = 0;
      $prcNumbers = array();
      foreach ($data as $row) {
        $row['first_name'] = trim($row[0] ?? null);
        $row['last_name'] = trim($row[2] ?? null);
        $row['prc_number'] = trim($row[8] ?? null);
        $row['birthdate'] = trim($row[3] ?? null);

        if (
          empty($row['first_name'])
          && empty($row['last_name'])
          && empty($row['prc_number'])
          && empty($row['birthdate'])
        ) {
          continue;
        }

        if ($index > 0) {
          $rowNo = $index + 1;
          // check for the correct column values
          if (empty($row['first_name'])) {
            exit(var_dump($row['first_name']));
            throw new Error('Column \'FIRSTNAME\' on \'row ' . $rowNo . '\' should not be empty. Try again');
          } else if (empty($row['last_name'])) {
            throw new Error('Column \'LASTNAME\' on \'row ' . $rowNo . '\'  should not be empty. Try again');
          } else if (empty($row['prc_number'])) {
            throw new Error('Column \'PRC NO.\' on \'row ' . $rowNo . '\' should not be empty. Try again');
          }

          if (!empty($row['birthdate'])) {
            if (!strtotime($row['birthdate']) || strlen($row['birthdate']) <= 1) {
              throw new Error($row['birthdate'] . 'on row \' ' . $rowNo . '\' is not a valid date value for the cell \'BIRTHDATE\'. It should be a date formatted in (MM/DD/YYYY). Try again');
            }

            $day = date('d', strtotime($row['birthdate']));
            $month = date('m', strtotime($row['birthdate']));
            $year = date('Y', strtotime($row['birthdate']));
            if (!checkdate($month, $day, $year)) {
              throw new Error($row['birthdate'] . 'on row \' ' . $rowNo . '\' is not a valid date value for the cell \'BIRTHDATE\'. It should have a correct Month, Day, and Year values. Try again');
            }
          }

          array_push($prcNumbers, ['prc_number' => $row['prc_number'], 'rowNo' => $rowNo]);
        }
        $index++;
      }

      $returnedDupes = $this->returnDuplicate($prcNumbers);
      if ($returnedDupes) {
        throw new Error('The PRC No. \'' . $returnedDupes['prc_number'] . '\' is a duplicate. Try again. The anomaly was detected on row ' . $returnedDupes['rowNo'] . ' column PRC NO.');
      };

      $index2 = 0;
      $inserts = [];
      foreach ($data as $row) {
        if ($index2 > 0) {
          $row['0'] = trim($row[0] ?? null);
          $row['2'] = trim($row[2] ?? null);
          $row['8'] = trim($row[8] ?? null);
          $row['3'] = trim($row[3] ?? null);

          if (
            empty($row['0'])
            && empty($row['2'])
            && empty($row['8'])
            && empty($row['3'])
          ) {
            continue;
          }

          if (isset($row[3]) && !empty(trim($row[3]))) {
            $row[3] = date('Y-m-d', strtotime(trim($row[3] ?? null))); // change format so that mysql accepts date
          }

          $this->profileModel->store($row);

          // array_push($inserts, $row);
        }
        $index2++;
      }

      // $this->profileModel->insertMultiple(
      //   array_values($inserts)
      // );



      $spreadsheetRowCount = sizeof($data);
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' imported ' . $spreadsheetRowCount . ' profiles.',
            'type' => 'add_profile',
          ]
        );
      }

      $reply = json_encode($decoded);

      header("Content-Type: application/json; charset=UTF-8");
      exit($reply);
    } catch (\Throwable $th) {
      header("Content-Type: application/json; charset=UTF-8");
      $decoded['status'] = 'fail';
      $decoded['message'] = $th->getCode() == '23000' ? 'The prc # \'' . $row[8] . '\' already has existing records in the database. Try again with a non-existing prc number. The anomaly was detected on Row ' . $index2 . ' PRC NO. column.' : $th->getMessage();
      $reply = json_encode($decoded);


      exit($reply);
    }
  }
  private function returnDuplicate($array): ?array
  {
    $prc_numbers = array();
    foreach ($array as $val) {
      array_push($prc_numbers, $val['prc_number']);
    }

    $unique = array_unique($prc_numbers);
    $duplicates = array_diff_assoc($prc_numbers, $unique);

    if (empty($duplicates)) {
      return null;
    }

    $firstDuplicateKey = array_key_first($duplicates);
    $firstDuplicateKey = $firstDuplicateKey + 1;

    foreach ($array as $val) {
      if ($duplicates[$firstDuplicateKey - 1] == $val['prc_number'] && $val['rowNo'] != $firstDuplicateKey - 1) {
        return ['prc_number' => $duplicates[$firstDuplicateKey - 1], 'rowNo' =>  $val['rowNo'] . ' and ' . ++$firstDuplicateKey];
      }
    }
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
  public function accountsDatatable()
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
      // $memberType = $_POST['memberType'];
      // $role = $_POST['role'];

      // initialize search filter
      $searchQuery = " and (role != 'superadmin')";
      if ($searchValue != '') {
        $searchQuery .= " and ( account_status = '" . $searchValue . "' OR  
          payment_status = '" . $searchValue . "' OR      
          first_name like '%" . $searchValue . "%' OR           
          last_name like '%" . $searchValue . "%' ) ";
      }

      // initilize columns to be selected
      $selectables = [];
      foreach ($_POST['columns'] as $column) {
        $selectables[] = 'users.*';
        $selectables[] = 'clinics.name AS clinic_name';
        $selectables[] = 'clinics.street AS clinic_street';
        $selectables[] = 'clinics.district AS clinic_district';
        $selectables[] = 'clinics.city AS clinic_city';
        $selectables[] = 'clinics.contact_number AS clinic_contact_number';
        $selectables[] = 'clinics.*';
      }

      // Row count without filtering
      $totalRecords = $this->userModel->countAll()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->userModel->countAllWithFilters($searchQuery)->count;

      // Fetch records
      $empRecords = $this->userModel->getDatatable($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);
      $data = array();

      // $row->is_active ? 'active' : 'inactive'
      foreach ($empRecords as $row) {
        $data[] = array(
          "created_at" => $row->created_at,
          "first_name" => $row->email,
          "role" => $row->role,
          "account_status" => $row->account_status,
          "logged_at" => $row->logged_at,
          "payment_status" => $row->payment_status,
          "status_remarks" => $row->status_remarks,
          "email" => $row->email,
          "prc_number" => $row->prc_number,
          "prc_registration_date" => $row->prc_registration_date,
          "prc_expiration_date" => $row->prc_expiration_date,
          "field_practice" => $row->field_practice,
          "type_practice" => $row->type_practice,
          "birthdate" => $row->birthdate,
          "gender" => $row->gender,
          "contact_number" => $row->contact_number,
          "fb_account_name" => $row->fb_account_name,
          "address" => $row->address,
          "clinic_name" => $row->clinic_name,
          "clinic_street" => $row->clinic_street,
          "clinic_district" => $row->clinic_district,
          "clinic_city" => $row->clinic_city,
          "clinic_contact_number" => $row->clinic_contact_number,
          "emergency_person_name" => $row->emergency_person_name,
          "emergency_address" => $row->emergency_address,
          "emergency_contact_number" => $row->emergency_contact_number
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

  public function memberList()
  {
    $accounts = $this->duesModel->getListOfMembersWithGroupedPayments();

    $data = [
      'current_route' => __FUNCTION__,

      'accounts' => $accounts,
    ];

    $this->view('admins/memberList', $data);
  }

  public function report()
  {
    $user = $this->userModel->getUserById($this->session->get(SessionManager::SESSION_USER)->id);
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

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' registered an amount of ' . $decoded['paymentForm']['amount'] . ' as dues payment to ' . $decoded['paymentForm']['type'] . ' with an OR No. of ' . $decoded['paymentForm']['or_number'],
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' imported ' . $spreadsheetRowCount . ' payments.',
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
    $user = $this->userModel->getUserById($this->session->get(SessionManager::SESSION_USER)->id);
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' ' . $statusValueLabel . ' ' . $userFullname,
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

      $user = $this->userModel->find(
        ['*'],
        ['id'],
        [$decoded['user_id']]
      );

      // check user status
      $role = '';
      if ($this->role->isAdmin($user->role)) {
        $role = Roles::ROLE_MEMBER;
      }
      if ($this->role->isMember($user->role)) {
        $role = Roles::ROLE_ADMIN;
      }

      // check if user status was not successfully updated
      if (!$this->userModel->update4(
        ['role'],
        [$role],
        ['id'],
        [$decoded['user_id']]
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

    $user = $this->profileModel->findProfileUser(
      ['*'],
      ['profiles.id'],
      [$userId]
    );

    $paymentHistory = $this->duesModel->getUserYearlyPayments(['user_id' => $userId]);

    $data = [
      'user' => $user,
      'current_route' => __FUNCTION__,

      'paymentHistory' => $paymentHistory,
      'years' => generateYearsBetween()
    ];

    if (!$user) {
      $data['profile_err'] = 'The profile containing the id \'' . $userId . '\' does not exist';
    }
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the profile of ' . $userFullname,
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the personal info of ' . $userFullname,
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the license info of ' . $userFullname,
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the clinic info of ' . $userFullname,
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
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the emergency info of ' . $userFullname,
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
