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
        $decoded['errors']['prc_number_err'] = 'prc number must not be empty';
      }

      if (empty($decoded['duesForm']['type'])) {
        $decoded['errors']['type_err'] = 'payment type must not be empty';
      }

      if (empty($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'amount must not be empty';
      } else if (!is_numeric($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'amount must be numeric';
      }

      if (empty($decoded['duesForm']['channel'])) {
        $decoded['errors']['channel_err'] = 'payment channel must not be empty';
      }

      if (empty($decoded['duesForm']['or_number'])) {
        $decoded['errors']['or_number_err'] = 'or number must not be empty';
      } else {
        if ($this->duesModel->hasRow(['or_number'], [$decoded['duesForm']['or_number']])) {
          $decoded['errors']['or_number_err'] = 'this or number is already taken';
        }
      }

      if (empty($decoded['duesForm']['date_posted']['month'])) {
        $decoded['errors']['date_posted_err'] = 'month must not be empty';
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
        throw new Error('The prc number: ' . $decoded['duesForm']['prc_number'] . ' does not have a linked profile. Try again.');
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
  public function updateDues()
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

      $decoded['message'] = 'New dues was successfully updated!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['duesForm']['prc_number'])) {
        $decoded['errors']['profile_id_err'] = 'prc number must not be empty';
      }

      if (empty($decoded['duesForm']['type'])) {
        $decoded['errors']['type_err'] = 'payment type must not be empty';
      }

      if (empty($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'amount must not be empty';
      } else if (!is_numeric($decoded['duesForm']['amount'])) {
        $decoded['errors']['amount_err'] = 'amount must be a numeric';
      }

      if (empty($decoded['duesForm']['channel'])) {
        $decoded['errors']['channel_err'] = 'payment channel must not be empty';
      }

      if (empty($decoded['duesForm']['or_number'])) {
        $decoded['errors']['or_number_err'] = 'or number must not be empty';
      } else {
        $due = $this->duesModel->find(['*'], ['id'], [$decoded['duesForm']['dues_id']]);
        if (
          $due->or_number !== $decoded['duesForm']['or_number']
          && $this->duesModel->hasRow(['or_number'], [$decoded['duesForm']['or_number']])
        ) {
          $decoded['errors']['or_number_err'] = 'this or number is already taken';
        }
      }

      if (empty($decoded['duesForm']['date_posted']['month'])) {
        $decoded['errors']['date_posted_err'] = 'Month must not be empty';
      }
      if ($decoded['duesForm']['date_posted']['month'] > 12 || $decoded['duesForm']['date_posted']['month'] < 1) {
        $decoded['errors']['date_posted_err'] = 'month must be a valid date of a month';
      }
      if (empty($decoded['duesForm']['date_posted']['year'])) {
        $decoded['errors']['date_posted_err'] = 'year must not be empty';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      $profile = $this->profileModel->find(
        ['*'],
        ['prc_number'],
        [$decoded['duesForm']['prc_number']]
      );

      if (!$profile) {
        $decoded['errors']['profile_id_err'] = 'There is no profile containing the prc number: ' . $decoded['duesForm']['prc_number'];
        throw new Error('There is no profile containing the prc number: ' . $decoded['duesForm']['prc_number']);
      }

      // reformat date
      $decoded['duesForm']['date_posted'] = $decoded['duesForm']['date_posted']['year'] . '-' . $decoded['duesForm']['date_posted']['month'] . '-01';

      $this->duesModel->update(
        [
          'profile_id', 'prc_number', 'type', 'amount', 'channel', 'or_number', 'remarks', 'date_posted'
        ],
        [
          $profile->id, $decoded['duesForm']['prc_number'], $decoded['duesForm']['type'], $decoded['duesForm']['amount'], $decoded['duesForm']['channel'], $decoded['duesForm']['or_number'], $decoded['duesForm']['remarks'], $decoded['duesForm']['date_posted']
        ],
        ['id'],
        [$decoded['duesForm']['dues_id']],
      );

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated a dues with an id of ' . $decoded['duesForm']['dues_id'],
            'type' => 'update_dues',
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

  public function deleteDues()
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

      $decoded['message'] = 'A dues was successfully deleted!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['dues_id'])) {
        $decoded['errors']['dues_id_err'] = 'Dues id must not be empty';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      if (!$this->duesModel->hasRow(
        ['id'],
        [$decoded['dues_id']]
      )) {
        throw new Error('Dues id: ' . $decoded['dues_id'] . ' does not exist.');
      }

      $due = $this->duesModel->find(['*'], ['id'], [$decoded['dues_id']]);
      $deleteVal = null;
      $archiveLabel = 'restore';
      if (empty($due->deleted_at)) {
        $deleteVal = date('Y-m-d H:i:s');
        $archiveLabel = 'archive';
      }

      $this->duesModel->update(
        [
          'deleted_at',
        ],
        [
          $deleteVal
        ],
        ['id'],
        [$decoded['dues_id']],
      );

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . $archiveLabel . 'd the dues with the row no. ' . $due->id,
            'type' => $archiveLabel . 'd_dues',
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

      $decoded['message'] = 'New payment(s) were successfully added!';
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

      $orNumbers = array();
      $orNumbersWithoutRows = array();
      $prcNumbersWithoutRows = array();
      $scannedRows = array();
      $emptyFailedRows = array();
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
          $rowNo = $index + 1;

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
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['prc_number'],
                'column' => 'PRC No',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['prc_number'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'PRC No',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['amount'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['amount'],
                'column' => 'AMOUNT',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['amount'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'AMOUNT',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['paid_to'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['paid_to'],
                'column' => 'PAID TO (PDA/DCC)',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['paid_to'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'PAID TO (PDA/DCC)',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (!empty($row['paid_to']) && !in_array(strtolower($row['paid_to']), ['pda', 'dcc'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['paid_to'],
                'column' => 'PAID TO (PDA/DCC)',
                'status' => 'INCORRECT INPUT',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['paid_to'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'PAID TO (PDA/DCC)',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INCORRECT INPUT',
              ];
            }
          } else if (empty($row['channel'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['channel'],
                'column' => 'PAYMENT CHANNEL',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['channel'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'PAYMENT CHANNEL',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['or_number'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['or_number'],
                'column' => 'OR NO',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['or_number'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'OR NO',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['date_posted'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['date_posted'],
                'column' => 'DATE POSTED',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['date_posted'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'DATE POSTED',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          }

          if (!is_numeric($row['amount'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['amount'],
                'column' => 'AMOUNT',
                'status' => 'NOT NUMERIC',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['amount'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'AMOUNT',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'NOT NUMERIC',
              ];
            }
          }

          $day = date('d', strtotime($row['date_posted']));
          $month = date('m', strtotime($row['date_posted']));
          $year = date('Y', strtotime($row['date_posted']));

          if (!strtotime($row['date_posted']) || strlen($row['date_posted']) <= 1) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['date_posted'],
                'column' => 'DATE POSTED',
                'status' => 'INVALID DATE',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['date_posted'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'DATE POSTED',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
              ];
            }
          }

          if (!checkdate($month, $day, $year)) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['date_posted'],
                'column' => 'DATE POSTED',
                'status' => 'INVALID DATE',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['date_posted'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'DATE POSTED',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
              ];
            }
          }
          // change format so that mysql accepts 
          $row['paid_to'] = strtoupper($row['paid_to']);
          $row['date_posted'] = date('Y-m-d', strtotime($row['date_posted']));

          array_push($scannedRows, $row);
          array_push($orNumbers, ['or_number' => $row['or_number'], 'rowNo' => $rowNo]);
          $prcNumbersWithoutRows[$rowNo] = $row['prc_number'];
          $orNumbersWithoutRows[$rowNo] = $row['or_number'];
        }

        $index++;
      }

      if (empty($scannedRows)) {
        throw new Error('Rows should not be empty. Try again');
      }

      if (!empty($emptyFailedRows) && sizeof($emptyFailedRows) > 0) {
        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'cell error';
        $decoded['rows'] = $emptyFailedRows;
        $decoded['failedCount'] = sizeof($emptyFailedRows);
        $decoded['passedCount'] = sizeof($emptyFailedRows) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to anomalies detected in spreadsheet.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      $noLinks = $this->profileModel->whereIn(['prc_number'], 'prc_number', array_values($prcNumbersWithoutRows));
      if ($noLinks) {
        foreach ($noLinks as $key => $value) {
          foreach (array_keys($prcNumbersWithoutRows, $value->prc_number, true) as $key) {
            unset($prcNumbersWithoutRows[$key]);
          }
        }
      }

      if (!empty($prcNumbersWithoutRows) && sizeof($prcNumbersWithoutRows) > 0) {
        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'prc not found';
        $decoded['rows'] = $prcNumbersWithoutRows;
        $decoded['failedCount'] = sizeof($prcNumbersWithoutRows);
        $decoded['passedCount'] = sizeof($prcNumbersWithoutRows) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to anomalies detected in spreadsheet.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      // set spreadsheet-level duplicate checking
      $returnedDupes = $this->returnDuplicate($orNumbers, 'or_number');
      //  dd($returnedDupes);
      if (!empty($returnedDupes) && sizeof($returnedDupes) > 0) {
        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'spreadsheet duplicate';
        $decoded['rows'] = $returnedDupes;
        $decoded['failedCount'] = sizeof($returnedDupes);
        $decoded['passedCount'] = sizeof($orNumbers) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to duplicate rows (or_number) detected in spreadsheet.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }


      // set db-level duplicate checking
      $orNumbersWithoutRows = array_unique($orNumbersWithoutRows);
      $dbDuplicates = $this->duesModel->whereIn(['or_number'], 'or_number', array_values($orNumbersWithoutRows));

      if (!empty($dbDuplicates) && sizeof($dbDuplicates) > 0) {
        $newORs = array();
        foreach ($dbDuplicates as $key => $value) {
          if (in_array($value->or_number, $orNumbersWithoutRows)) {
            $k = array_search($value->or_number, $orNumbersWithoutRows);
            $dbDuplicates[$k] = $value;
            $newORs[$k] = $orNumbersWithoutRows[$k];
          }
        }
        ksort($newORs);

        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'database duplicate';
        $decoded['rows'] = $newORs;
        $decoded['failedCount'] = sizeof($newORs);
        $decoded['passedCount'] = sizeof($orNumbersWithoutRows) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to duplicate rows (prc_number) detected in database.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      $profiles =  $this->profileModel->get(
        ['*'],
        ['1'],
        ['1'],
      );

      foreach ($profiles as $key => $value) {
        $profileVal = $value;
        foreach ($scannedRows as $key => $value) {
          if ($profileVal->prc_number == $value['prc_number']) {
            $scannedRows[$key]['profile_id'] = $profileVal->id;
          }
        }
      }

      $this->duesModel->insertMultiple(
        array_values($scannedRows)
      );

      //     $last_row->profile_id = !empty($last_row->profile_id) ? 'Linked (' . $row["profile_name"] . ')' : 'No links';
      //     $insertedRows[] = $last_row; // returns the last row
      //     $insertedRowInfos[] = $last_row->type . ' - ' . date('Y', strtotime($last_row->date_posted)) . ' (#' . $last_row->or_number . ')';

      $decoded['insertedRows'] = $scannedRows;
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' imported ' . count($scannedRows) . ' payments',
            'type' => 'import_dues',
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
      // $paymentStatus = $_POST['paymentStatus'];
      $paymentType = $_POST['paymentType'];
      $includeDeleted = $_POST['includeDeleted'];

      // initialize search filter
      $searchQuery = ' and dues.deleted_at IS NULL ';
      if ($includeDeleted == 'show') {
        $searchQuery = '';
      }
      if ($includeDeleted == 'hide') {
        $searchQuery = ' and dues.deleted_at IS NULL ';
      }
      if ($includeDeleted == 'only') {
        $searchQuery = ' and dues.deleted_at IS NOT NULL ';
      }

      if ($searchValue != '') {
        $searchQuery .= " and (date_posted like '%" . $searchValue . "%' OR 
          type like '%" . $searchValue . "%' OR 
          CONCAT(first_name, ' ', SUBSTR(middle_name, 1, 1), ' ', last_name) LIKE '%" . $searchValue . "%' OR
          CONCAT(last_name, ' ', first_name, ' ', middle_name) LIKE '%" . $searchValue . "%' OR
          channel like '%" . $searchValue . "%' OR 
          or_number like '%" . $searchValue . "%' ) ";
      }

      if ($startMonth != '' && $endMonth != '' && $startYear != '' &&  $endYear != '') {
        $searchQuery .= " and (date_posted BETWEEN CONCAT('" . $startYear . "','-','" . $startMonth . "','-01') AND CONCAT('" . $endYear . "','-','" . $endMonth . "','-01')) ";
      }

      if ($paymentType != '') {
        $searchQuery .= " and (dues.type like '%" . $paymentType . "%') ";
      }

      // initilize columns to be selected
      $selectables = [];
      foreach ($_POST['columns'] as $column) {
        $selectables[] = 'profiles.*';
        $selectables[] = 'accounts.email';
        $selectables[] = 'dues.*';
      }

      // Row count without filtering
      $totalRecords = $this->duesModel->countAll2()->count;

      // Row count with filtering
      $totalRecordwithFilter = $this->duesModel->countAllWithFilters2($searchQuery)->count;

      // Fetch all/filtered records
      $empRecords = $this->duesModel->getDatatable2($selectables, $searchQuery, $columnName, $columnSortOrder, $row, $rowperpage);

      // fetch filtered amount
      $totalFilteredAmount = $this->duesModel->getDatatable3($selectables, $searchQuery);

      $data = array();

      foreach ($empRecords as $row) {
        $data[] = array(
          "date_posted" => date('Y-M', strtotime($row->date_posted)),
          "last_name" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name) ?? '',
          "amount" => $row->amount,
          "type" => $row->type,
          "or_number" => $row->or_number ?? '',
          "remarks" => $row->remarks ?? '',
          "channel" => $row->channel ?? '',
          'user_id' => $row->profile_id,
          'dues.id' => $row->id,
          'total_amount' => $totalFilteredAmount->total_filtered_amount,
          'deleted_at' => empty($row->deleted_at) ? false : true,

          "surname" => $row->last_name,
          "first_name" => $row->first_name,
          "middle_name" => $row->middle_name,
          "prc_number" => $row->prc_number,
          "contact_number" => $row->contact_number,
          "email" => $row->email,
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
      $includeDeleted = $_POST['includeDeleted'];

      // initialize search filter
      $searchQuery = " AND deleted_at IS NULL ";
      if ($includeDeleted == 'show') {
        $searchQuery = '';
      }
      if ($includeDeleted == 'hide') {
        $searchQuery = ' and deleted_at IS NULL ';
      }
      if ($includeDeleted == 'only') {
        $searchQuery = ' and deleted_at IS NOT NULL ';
      }

      $searchQuery .= " AND email_verified != false";
      if ($searchValue != '') {
        $searchQuery .= " and ( account_status = '" . $searchValue . "') ";
      }
      if ($role != '') {
        $searchQuery .= " and ( role = '" . $role . "') ";
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

        if (strtolower($accountStatus) == 'inactive') {
          if ($dateInSixMonthsSinceLastLog >= $today) {
            continue;
          }
        } else if (strtolower($accountStatus) == 'active') {
          if ($dateInSixMonthsSinceLastLog <= $today) {
            continue;
          }
        }

        $data[] = array(
          "profile_img_path" => $row->profile_img_path,
          "thumbnail_img_path" => $row->thumbnail_img_path,
          "created_at" => $row->created_at,
          "email" => $row->email,
          "role" => $row->role,
          "account_status" => $dateInSixMonthsSinceLastLog <= $today ? 'inactive' : 'active',
          "is_online" => $row->is_online ? 'online' : 'offline',
          "logged_at" => $row->logged_at,
          "deleted_at" => $row->deleted_at,

          "user_id" => $row->id,
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
  public function archiveUser()
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

      $decoded['message'] = 'A profile was successfully deleted!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['user_id'])) {
        $decoded['errors']['user_id_err'] = 'Your user id must not be empty';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      if (!$this->userModel->hasRow(
        ['id'],
        [$decoded['user_id']]
      )) {
        throw new Error('User id: ' . $decoded['user_id'] . ' does not exist.');
      }

      $user = $this->userModel->find(['*'], ['id'], [$decoded['user_id']]);
      $deleteVal = null;
      $archiveLabel = 'restore';
      if (empty($user->deleted_at)) {
        $deleteVal = date('Y-m-d H:i:s');
        $archiveLabel = 'archive';
      }

      $this->userModel->update4(
        [
          'deleted_at',
        ],
        [
          $deleteVal
        ],
        ['id'],
        [$decoded['user_id']],
      );

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . $archiveLabel . 'd the user with the email ' . $user->email,
            'type' => $archiveLabel . 'd_profile',
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
      $includeDeleted = $_POST['includeDeleted'];

      // initialize search filter
      $searchQuery = ' and profiles.deleted_at IS NULL ';
      if ($includeDeleted == 'show') {
        $searchQuery = '';
      }
      if ($includeDeleted == 'hide') {
        $searchQuery = ' and profiles.deleted_at IS NULL ';
      }
      if ($includeDeleted == 'only') {
        $searchQuery = ' and profiles.deleted_at IS NOT NULL ';
      }

      $searchQuery .= " and first_name IS NOT NULL and last_name IS NOT NULL and prc_number IS NOT NULL ";
      if ($searchValue != '') {
        $searchQuery .= " and ( CONCAT(first_name, ' ', SUBSTR(middle_name, 1, 1), ' ', last_name) LIKE '%" . $searchValue . "%' OR
          CONCAT(last_name, ' ', first_name, ' ', middle_name) LIKE '%" . $searchValue . "%' OR
          prc_number LIKE '%" . $searchValue . "%') ";
      }

      // initilize columns to be selected
      $selectables = [];
      $selectables[] = 'GROUP_CONCAT(YEAR(cd_dues.cd_dates)) AS dcc_dates';
      $selectables[] = 'GROUP_CONCAT(YEAR(pda_dues.pda_dates)) AS pda_dates';
      // $selectables[] = 'GROUP_CONCAT(YEAR(dues.date_posted)) AS date_posted';
      $selectables[] = 'CONCAT(GROUP_CONCAT(CONCAT(YEAR(cd_dues.cd_dates), IFNULL(CONCAT(" (#: ", cd_dues.or_number, ")" ), "")) SEPARATOR ", "), IFNULL(CONCAT(" (", status_remarks, ")" ), "")) AS dcc_dues';
      $selectables[] = 'CONCAT(GROUP_CONCAT(CONCAT(YEAR(pda_dues.pda_dates), IFNULL(CONCAT(" (#: ", pda_dues.or_number, ")" ), "")) SEPARATOR ", "), IFNULL(CONCAT(" (", status_remarks, ")" ), "")) AS pda_dues';
      $selectables[] = 'profiles.*';
      $selectables[] = 'profiles.deleted_at AS deleted_at';
      $selectables[] = 'accounts.email';
      $selectables[] = 'accounts.profile_img_path';
      $selectables[] = 'accounts.thumbnail_img_path';


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
        $combinedDatePosted = [];
        $combinedDatePosted[] = $row->dcc_dates;
        $combinedDatePosted[] = $row->pda_dates;
        array_unique($combinedDatePosted);
        // $paymentDates = explode(',', $combinedDatePosted);
        if (!empty($paymentDates[0])) sort($combinedDatePosted, SORT_NUMERIC);

        $firstYearOfPayment = $combinedDatePosted[0];
        $missingYears = $this->getMissingYears($combinedDatePosted, $firstYearOfPayment);
        $paymentStats = '';

        if (empty($missingYears)) $paymentStats = 'Complete Payment';
        else $paymentStats = 'Incomplete Payment';
        if (empty($firstYearOfPayment)) $paymentStats = '';
        if (
          in_array($lastThreeYears[0], $missingYears) &&
          in_array($lastThreeYears[1], $missingYears) &&
          in_array($lastThreeYears[2], $missingYears)
        ) $paymentStats = 'Dormant';

        // filter by payment status
        if ($paymentStatus != '') {
          if (strtolower($paymentStatus) != strtolower($paymentStats)) {
            continue;
          }
        }

        $data[] = array(
          "dcc_dues" => $row->dcc_dues ?? '',
          "pda_dues" => $row->pda_dues ?? '',

          "prc_number" => $row->prc_number,
          "last_name" => $row->last_name,
          "first_name" => $row->first_name,
          "middle_name" => $row->middle_name,
          "payment_status" => $paymentStats,
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

          "email" => $row->email,
          "profile_img_path" => $row->profile_img_path,
          "thumbnail_img_path" => $row->thumbnail_img_path,

          'profiles.id' => $row->id,
          "deleted_at" => $row->deleted_at,

          "fullname" => arrangeFullname($row->first_name, $row->middle_name, $row->last_name) ?? '',
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
  public function archiveProfile()
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

      $decoded['message'] = 'A profile was successfully deleted!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['profile_id'])) {
        $decoded['errors']['profile_id_err'] = 'Your profile] id must not be empty';
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      if (!$this->profileModel->hasRow(
        ['id'],
        [$decoded['profile_id']]
      )) {
        throw new Error('Profile id: ' . $decoded['profile_id'] . ' does not exist.');
      }

      $profile = $this->profileModel->find(['*'], ['id'], [$decoded['profile_id']]);
      $deleteVal = null;
      $archiveLabel = 'restore';
      if (empty($profile->deleted_at)) {
        $deleteVal = date('Y-m-d H:i:s');
        $archiveLabel = 'archive';
      }

      $this->profileModel->update3(
        [
          'deleted_at',
        ],
        [
          $deleteVal
        ],
        ['id'],
        [$decoded['profile_id']],
      );

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . $archiveLabel . 'd the profile with the id no. ' . $profile->id,
            'type' => $archiveLabel . 'd_profile',
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

      $emptyFailedRows = array();
      $index = 0;
      $prcNumbers = array();
      $prcNumbersWithoutRows = array();
      $inserts = array();
      foreach ($data as $row) {
        $row['first_name'] = trim($row[0] ?? null);
        $row['last_name'] = trim($row[2] ?? null);
        $row['prc_number'] = trim($row[8] ?? null);
        $row['birthdate'] = trim($row[3] ?? null);

        $row[3] = trim($row[3] ?? null);
        $row[9] = trim($row[9] ?? null);
        $row[10] = trim($row[10] ?? null);

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
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['first_name'],
                'column' => 'FIRSTNAME',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['first_name'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'FIRSTNAME',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['last_name'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['last_name'],
                'column' => 'LASTNAME',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['last_name'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'LASTNAME',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          } else if (empty($row['prc_number'])) {
            if (!isset($emptyFailedRows[$rowNo])) {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $row['prc_number'],
                'column' => 'PRC NO',
                'status' => 'EMPTY CELL',
              ];
            } else {
              $emptyFailedRows[$rowNo] = [
                'rowNo' => $rowNo,
                'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['prc_number'],
                'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'PRC NO',
                'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'EMPTY CELL',
              ];
            }
          }

          if (!empty($row['birthdate'])) {
            if (!strtotime($row['birthdate']) || strlen($row['birthdate']) <= 1) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $row['birthdate'],
                  'column' => 'BIRTHDATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['birthdate'],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'BIRTHDATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $day = date('d', strtotime($row['birthdate']));
            $month = date('m', strtotime($row['birthdate']));
            $year = date('Y', strtotime($row['birthdate']));
            if (!checkdate($month, $day, $year)) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $row['birthdate'],
                  'column' => 'BIRTHDATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row['birthdate'],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'BIRTHDATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $row['birthdate'] = date('Y-m-d', strtotime($row['birthdate']));
          }

          // prc reg date
          if (!empty($row[9])) {
            if (!strtotime($row[9]) || strlen($row[9]) <= 1) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' =>  $row[9],
                  'column' => 'REGISTRATION DATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row[9],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'REGISTRATION DATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $day = date('d', strtotime($row[9]));
            $month = date('m', strtotime($row[9]));
            $year = date('Y', strtotime($row[9]));
            if (!checkdate($month, $day, $year)) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' =>  $row[9],
                  'column' => 'REGISTRATION DATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row[9],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'REGISTRATION DATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $row[9] = date('Y-m-d', strtotime($row[9]));
          }

          // prc expiry date
          if (!empty($row[10])) {
            if (!strtotime($row[10]) || strlen($row[10]) <= 1) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' =>  $row[10],
                  'column' => 'EXPIRY DATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row[10],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'EXPIRY DATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $day = date('d', strtotime($row[10]));
            $month = date('m', strtotime($row[10]));
            $year = date('Y', strtotime($row[10]));
            if (!checkdate($month, $day, $year)) {
              if (!isset($emptyFailedRows[$rowNo])) {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' =>  $row[10],
                  'column' => 'EXPIRY DATE',
                  'status' => 'INVALID DATE',
                ];
              } else {
                $emptyFailedRows[$rowNo] = [
                  'rowNo' => $rowNo,
                  'value' => $emptyFailedRows[$rowNo]['value'] . ',' . $row[10],
                  'column' => $emptyFailedRows[$rowNo]['column'] . ',' . 'EXPIRY DATE',
                  'status' => $emptyFailedRows[$rowNo]['status'] . ',' . 'INVALID DATE',
                ];
              }
            }

            $row[10] = date('Y-m-d', strtotime($row[10]));
          }

          array_push($prcNumbers, ['prc_number' => $row['prc_number'], 'rowNo' => $rowNo]);
          array_push($inserts, $row);
          $prcNumbersWithoutRows[$rowNo] = $row['prc_number'];
        }
        $index++;
      }

      if (!empty($emptyFailedRows) && sizeof($emptyFailedRows) > 0) {
        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'cell error';
        $decoded['rows'] = $emptyFailedRows;
        $decoded['failedCount'] = sizeof($emptyFailedRows);
        $decoded['passedCount'] = sizeof($emptyFailedRows) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to anomalies detected in spreadsheet.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      // set spreadsheet-level duplicate checking
      $returnedDupes = $this->returnDuplicate($prcNumbers);
      if (!empty($returnedDupes) && sizeof($returnedDupes) > 0) {
        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'spreadsheet duplicate';
        $decoded['rows'] = $returnedDupes;
        $decoded['failedCount'] = sizeof($returnedDupes);
        $decoded['passedCount'] = sizeof($prcNumbers) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to duplicate rows (prc_number) detected in spreadsheet.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      // set db-level duplicate checking
      $prcNumbersWithoutRows = array_unique($prcNumbersWithoutRows);
      $dbDuplicates = $this->profileModel->whereIn(['prc_number'], 'prc_number', array_values($prcNumbersWithoutRows));
      if (!empty($dbDuplicates) && sizeof($dbDuplicates) > 0) {
        $newPrcs = array();
        foreach ($dbDuplicates as $key => $value) {
          if (in_array($value->prc_number, $prcNumbersWithoutRows)) {
            $k = array_search($value->prc_number, $prcNumbersWithoutRows);
            $dbDuplicates[$k] = $value;
            $newPrcs[$k] = $prcNumbersWithoutRows[$k];
          }
        }
        ksort($newPrcs);

        $decoded['status'] = 'fail';
        $decoded['error_title'] = 'database duplicate';
        $decoded['rows'] = $newPrcs;
        $decoded['failedCount'] = sizeof($newPrcs);
        $decoded['passedCount'] = sizeof($prcNumbersWithoutRows) - $decoded['failedCount'];
        $decoded['message'] = $decoded['failedCount'] . ' entries were unsuccessful due to duplicate rows (prc_number) detected in database.';

        $reply = json_encode($decoded);
        header("Content-Type: application/json; charset=UTF-8");
        exit($reply);
      }

      $this->profileModel->insertMultiple(
        array_values($inserts)
      );

      $decoded['insertedRows'] = $inserts;
      $spreadsheetRowCount = sizeof($inserts);
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
      $decoded['message'] = $th->getMessage();
      $reply = json_encode($decoded);


      exit($reply);
    }
  }
  private function returnDuplicate($array, $field = 'prc_number'): ?array
  {
    $errs = array();
    $added = array();
    foreach ($array as $val) {
      if (in_array($val[$field], $added)) {
        $errs[$val['rowNo']] = $val[$field];
      }
      $added[$val['rowNo']] = $val[$field];
    }

    $uniques = array_unique($errs);
    foreach ($uniques as $rowNo => $prc) {
      $k = array_search($prc, $added);
      $errs[$k] = $prc;
    }

    $newArr = array();
    ksort($errs, SORT_ASC);
    foreach ($errs as $key => $value) {
      $newArr[] = [
        'rowNo' => $key,
        $field => $value
      ];
    }
    return $newArr;


    // $unique = array_unique($prc_numbers);
    // $duplicates = array_diff_assoc($prc_numbers, $unique);

    // if (empty($duplicates)) {
    //   return null;
    // }

    // $firstDuplicateKey = array_key_first($duplicates);
    // $firstDuplicateKey = $firstDuplicateKey + 1;

    // foreach ($array as $val) {
    //   if ($duplicates[$firstDuplicateKey - 1] == $val['prc_number'] && $val['rowNo'] != $firstDuplicateKey - 1) {
    //     return ['prc_number' => $duplicates[$firstDuplicateKey - 1], 'rowNo' =>  $val['rowNo'] . ' and ' . ++$firstDuplicateKey];
    //   } else {
    //     return ['prc_number' => $duplicates[$firstDuplicateKey], 'rowNo' =>  $val['rowNo'] + 1 . ' and ' . $val['rowNo'] + 1];
    //   }
    // }
  }

  // public function memberList()
  // {
  //   $accounts = $this->duesModel->getListOfMembersWithGroupedPayments();

  //   $data = [
  //     'current_route' => __FUNCTION__,

  //     'accounts' => $accounts,
  //   ];

  //   $this->view('admins/memberList', $data);
  // }

  public function report()
  {
    $user = $this->session->auth();
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

  public function activities()
  {
    $activities = $this->activityModel->get();

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
      $reassignLabel = '';
      if ($this->role->isAdmin($user->role)) {
        $role = Roles::ROLE_MEMBER;
        $reassignLabel = 'retire';
      }
      if ($this->role->isMember($user->role)) {
        $role = Roles::ROLE_ADMIN;
        $reassignLabel = 'assign';
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

      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . $reassignLabel . 'd as admin the user with an email: ' . $user->email,
            'type' => $reassignLabel . 'd_admin',
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

  // public function filterData()
  // {
  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  //     $amounts = $this->duesModel->getTotalAmountBetweenYears($_POST['startYear'], $_POST['endYear'], $_POST['startMonth'], $_POST['endMonth']);

  //     exit(json_encode(['data' => $amounts, 'status' => 'ok', 'code' => 200, 'message' => 'request successful']));
  //   }
  // }

  // public function paymentBreakdown()
  // {
  //   if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  //     $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
  //     $amountsPDA = $this->duesModel->getPaymentsByUserAndType($_POST['user_id'], 'PDA', $_POST['startYear'], $_POST['endYear']);
  //     $amountsDCC = $this->duesModel->getPaymentsByUserAndType($_POST['user_id'], 'DCC', $_POST['startYear'], $_POST['endYear']);

  //     exit(json_encode(
  //       [
  //         'data' => ['pda' => $amountsPDA, 'dcc' => $amountsDCC], 'status' => 'ok', 'code' => 200, 'message' => 'request successful'
  //       ]
  //     ));
  //   }
  // }


  public function viewAccount()
  {
    $userId = $_GET['id'];

    $user = $this->profileModel->findProfileUser(
      ['*', 'profiles.id AS id', 'accounts.id AS user_id'],
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

        $user = $this->userModel->find(['*'], ['profile_id'], [$decoded['profile']['user_id']]);
        if (
          $user->email !== $decoded['profile']['email']
          && $this->userModel->hasRow(['email'], [$decoded['profile']['email']])
        ) {
          $decoded['errors']['email_err'] = 'this email is already taken';
        }
      }

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      // check if payment insert is unsuccessful or prc number does not exist
      if (!$this->userModel->update4(
        ['email'],
        [$decoded['profile']['email']],
        ['profile_id'],
        [$decoded['profile']['user_id']]
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['profile']['user_id']]);

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
  public function updateProfileRemarks()
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

      $decoded['message'] = 'Profile remarks was successfully updated!';
      $decoded['status'] = 'ok';
      $decoded['errors'] = [];

      // check inputs
      if (empty($decoded['profile_id'])) {
        $decoded['errors']['profile_id_err'] = 'The field \'Profile id\' should not be empty';
      }
      // if (empty($decoded['remarks'])) {
      //   $decoded['errors']['remarks_err'] = 'Your email should not be empty';
      // } 

      if (sizeof($decoded['errors']) > 0) {
        throw new Error('You have some input errors. Please check your inputs');
      }

      // check if payment insert is unsuccessful or prc number does not exist
      if (!$this->profileModel->update3(
        ['status_remarks'],
        [$decoded['remarks']],
        ['id'],
        [$decoded['profile_id']]
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['profile_id']]);

      $userFullname = arrangeFullname($user->first_name, $user->middle_name, $user->last_name);
      if ($this->role->isAdmin($this->session->get(SessionManager::SESSION_USER)->role)) {
        $this->activityModel->store(
          [
            'user_id' =>     $this->session->get(SessionManager::SESSION_USER)->id,
            'initiator' => $this->currentUserFullname,
            'message' => 'Admin: ' . $this->currentUserFullname . ' updated the profile remarks of ' . $userFullname,
            'type' => 'update_profile_remarks',
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
        // $decoded['errors']['middle_name_err'] = 'Please enter your middlename';
      }
      if (empty($decoded['personal']['last_name'])) {
        $decoded['errors']['last_name_err'] = 'Please enter your lastname';
      }
      if (empty($decoded['personal']['birthdate'])) {
        $decoded['personal']['birthdate'] = null;
        // $decoded['errors']['birthdate_err'] = 'Please enter your your birthdate';
      }
      if (empty($decoded['personal']['gender'])) {
        // $decoded['errors']['gender_err'] = 'Please select your gender';
      }
      if (empty($decoded['personal']['contact_number'])) {
        // $decoded['errors']['contact_number_err'] = 'Please enter your contact number';
      }
      if (empty($decoded['personal']['fb_account_name'])) {
        // $decoded['errors']['fb_account_name_err'] = 'Please enter your fb account name';
      }
      if (empty($decoded['personal']['address'])) {
        // $decoded['errors']['address_err'] = 'Please enter your home address';
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
        [$decoded['personal']['user_id']]
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['personal']['user_id']]);

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
        // $decoded['errors']['prc_registration_date_err'] = 'Please enter your prc_registration_date';
        $decoded['license']['prc_registration_date'] = null;
      }
      if (empty($decoded['license']['prc_expiration_date'])) {
        // $decoded['errors']['prc_expiration_date_err'] = 'Please enter your prc_expiration_date';
        $decoded['license']['prc_expiration_date'] = null;
      }
      if (empty($decoded['license']['field_practice'])) {
        // $decoded['errors']['field_practice_err'] = 'Please enter your your field_practice';
      }
      if (empty($decoded['license']['type_practice'])) {
        // $decoded['errors']['type_practice_err'] = 'Please select your type_practice';
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
        [$decoded['license']['user_id']]
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
        [$decoded['license']['user_id']]
      );

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['license']['user_id']]);

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
        // $decoded['errors']['clinic_name_err'] = 'Please enter your clinic_name';
      }
      if (empty($decoded['clinic']['clinic_street'])) {
        // $decoded['errors']['clinic_street_err'] = 'Please enter your clinic_street';
      }
      if (empty($decoded['clinic']['clinic_district'])) {
        // $decoded['errors']['clinic_district_err'] = 'Please enter your clinic_district';
      }
      if (empty($decoded['clinic']['clinic_city'])) {
        // $decoded['errors']['clinic_city_err'] = 'Please enter your your clinic_city';
      }
      if (empty($decoded['clinic']['clinic_contact_number'])) {
        // $decoded['errors']['clinic_contact_number_err'] = 'Please select your clinic_contact_number';
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
        [$decoded['clinic']['user_id']]
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['clinic']['user_id']]);

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
        // $decoded['errors']['emergency_person_name_err'] = 'Please enter your emergency_person_name';
      }
      if (empty($decoded['emergency']['emergency_address'])) {
        // $decoded['errors']['emergency_address_err'] = 'Please enter your emergency_address';
      }
      if (empty($decoded['emergency']['emergency_contact_number'])) {
        // $decoded['errors']['emergency_contact_number_err'] = 'Please enter your emergency_contact_number';
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
        [$decoded['emergency']['user_id']]
      )) {
        throw new Error('Something went wrong with the updating of the email. Try again');
      }

      $user = $this->profileModel->findProfileUser(['*'], ['profiles.id'], [$decoded['emergency']['user_id']]);

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

  public function fetchSingleDues()
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
      if (empty($decoded['dues_id'])) {
        $decoded['errors']['user_id_err'] = 'Please enter a user_id';
      }

      $decoded['dues'] = $this->duesModel->find(
        ['*'],
        ['id'],
        [$decoded['dues_id']]
      );

      $decoded['date_posted_year'] = date('Y', strtotime($decoded['dues']->date_posted));
      $decoded['date_posted_month'] = date('m', strtotime($decoded['dues']->date_posted));

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
