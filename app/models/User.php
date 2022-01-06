<?php
class User extends Model
{
  public $db;
  public $table = 'users';
  public $table2 = 'accounts';
  public $primaryKey = 'id';
  public $joinedPrimarykey = '';

  public function __construct()
  {
    $this->db = new Database;
    $this->joinedPrimarykey =  $this->table . '.' . $this->primaryKey;
  }


  public function deletePermanent(array $filterCols, array $filterVals)
  {
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'DELETE FROM ' . $this->table2 . ' WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function delete(array $filterCols, array $filterVals)
  {
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'UPDATE ' . $this->table2 . ' SET deleted_at = NOW() WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function resetPasswordAndReturnUnencryptedVersion($id)
  {
    $permitted_chars = uniqid();
    $offset = strlen($permitted_chars) - 5;
    $newPassword = substr(str_shuffle($permitted_chars), 0, $offset);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = 'UPDATE ' . $this->table2 . ' 
            SET 
              password = :password 
              WHERE id = :id
              ';
    $this->db->query($sql);

    $this->db->bind(':password', $hashedPassword);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return $newPassword;
    } else {
      return false;
    }
  }

  public function getDatatable2($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table2 . ' WHERE 1 ' .
      $filters . ' ORDER BY ' .
      $orderColumn . ' ' .
      $orderType . ' LIMIT ' .
      $limitRow . ',' .
      $limitPerpage;

    $this->db->query($sql);

    return $this->db->resultSet();
  }
  function countAll2()
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table2;
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllWithFilters2($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table2 . ' WHERE 1 ' . $filters;
    $this->db->query($sql);

    return $this->db->single();
  }

  public function getDatatable($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table . ' LEFT JOIN clinics ON clinics.user_id = ' .
      $this->joinedPrimarykey . ' WHERE 1 ' .
      $filters . ' ORDER BY ' .
      $orderColumn . ' ' .
      $orderType . ' LIMIT ' .
      $limitRow . ',' .
      $limitPerpage;

    $this->db->query($sql);

    return $this->db->resultSet();
  }
  function countAll()
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN clinics ON clinics.user_id = ' . $this->joinedPrimarykey;
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllWithFilters($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN clinics ON clinics.user_id = ' . $this->joinedPrimarykey . ' WHERE 1 ' . $filters;
    $this->db->query($sql);

    return $this->db->single();
  }

  public function getUserClinic($data)
  {
    return $this->db->selectWithSingleJoin(
      $data['id'],
      $data['idType'],
      $this->table,
      'clinics',
      'users.id',
      'clinics.user_id',
      ['users.*', 'clinics.user_id, clinics.name AS clinic_name, clinics.street AS clinic_street, clinics.district AS clinic_district, clinics.city AS clinic_city, clinics.contact_number AS clinic_contact_number'],
      'desc'
    );
  }
  public function getAllUserClinic()
  {
    return $this->db->selectAllWithSingleJoin(
      $this->table,
      'clinics',
      $this->joinedPrimarykey,
      'clinics.user_id',
      [
        'users.*',
        'clinics.name AS clinic_name',
        'clinics.street AS clinic_street',
        'clinics.district AS clinic_district',
        'clinics.city AS clinic_city',
        'clinics.contact_number AS clinic_contact_no'
      ],
      'desc'
    );
  }
  public function getAll($columns = [], $values = [], $hasAdmin = true)
  {
    return $this->db->selectAll($this->table, $columns, $values, $hasAdmin);
  }

  // Regsiter user
  public function register($data)
  {
    $emailVkey = uniqid();

    $this->db->query(
      'INSERT INTO users 
        (first_name, last_name, email, role, password, fb_user_id, fb_access_token, google_user_id, google_access_token, email_vkey) 
      VALUES
        (:first_name, :last_name, :email, :role, :password, :fb_user_id, :fb_access_token, :google_user_id, :google_access_token, :email_vkey)
      '
    );

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':role', $data['role'] ?? 'member');
    $this->db->bind(':email_vkey', $emailVkey);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':fb_user_id', $data['fb_user_id']);
    $this->db->bind(':fb_access_token', $data['fb_access_token']);
    $this->db->bind(':google_user_id', $data['google_user_id']);
    $this->db->bind(':google_access_token', $data['google_access_token']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function regenerateVkey($vkeyType, $idType, $id)
  {
    $randomVkey = uniqid();

    // $this->db->query(
    //   'UPDATE users 
    //    SET '
    //     . $vkeyType . ' = :vkey
    //      WHERE ' . $idType . ' = :user_id 
    //   '
    // );

    $this->db->query(
      'UPDATE ' . $this->table2 . ' 
       SET '
        . $vkeyType . ' = :vkey
         WHERE ' . $idType . ' = :user_id 
      '
    );

    $this->db->bind(':vkey', $randomVkey);
    $this->db->bind(':user_id', $id);

    if ($this->db->execute()) {
      return $randomVkey;
    } else {
      return false;
    }
  }
  // public function removeEmailVkey($idType, $id)


  public function removeThirdPartyAuth($id, $accessToken, $userId)
  {
    $this->db->query(
      'UPDATE users 
       SET '
        . $id . ' = null, '
        . $accessToken . ' = null
         WHERE id = :user_id 
      '
    );

    $this->db->bind(':user_id', $userId);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Login User
  public function login($email, $password)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email AND email_verified = true');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    if (!$row) {
      return false;
    }

    $hashed_password = $row->password;
    if (password_verify($password, $hashed_password)) {
      return $row;
    } else {
      return false;
    }
  }

  public function getVerifiedUserByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email AND email_verified = true');
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    if (!$row) {
      return false;
    }
    return $row;
  }

  // Update user profile
  public function update($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        email = :email,
        password = :password
         WHERE id = :user_id 
      '
    );

    $this->db->bind(':email', $data['email']);
    $this->db->bind(':password', $data['password']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function update2($columns, $values, $idType, $id)
  {
    return $this->db->update($this->table, $columns, $values, $idType, $id);
  }

  public function update3($columns, $values, $idType, $id)
  {
    return $this->db->update($this->table2, $columns, $values, $idType, $id);
  }

  public function update4($columns, $values, $idType, $id)
  {
    return $this->db->update2($this->table2, $columns, $values, $idType, $id);
  }

  public function verifyEmail($data)
  {
    // $this->db->query(
    //   'UPDATE users 
    //      SET
    //       email_verified = :email_verified
    //        WHERE id = :user_id AND email_vkey = :email_vkey
    //     '
    // );
    $this->db->query(
      'UPDATE ' . $this->table2 . ' SET email_verified = :email_verified WHERE id = :user_id AND email_vkey = :email_vkey
        '
    );

    $this->db->bind(':email_verified', $data['email_verified']);
    $this->db->bind(':email_vkey', $data['email_vkey']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function changeEmail($data)
  {
    $this->db->query(
      'UPDATE users 
         SET
          email = :new_email,
          new_email = null
           WHERE id = :user_id AND email_vkey = :email_vkey AND new_email IS NOT NULL
        '
    );

    $this->db->bind(':new_email', $data['new_email']);
    $this->db->bind(':email_vkey', $data['email_vkey']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function updatePrcInfo($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        prc_number = :prc_number, prc_registration_date = :prc_registration_date, 
        prc_expiration_date = :prc_expiration_date, field_practice = :field_practice, 
        type_practice = :type_practice
         WHERE id = :user_id 
      '
    );

    $this->db->bind(':prc_number', $data['prc_number']);
    $this->db->bind(':prc_registration_date', $data['prc_registration_date']);
    $this->db->bind(':prc_expiration_date', $data['prc_expiration_date']);
    $this->db->bind(':field_practice', $data['field_practice']);
    $this->db->bind(':type_practice', $data['type_practice']);
    $this->db->bind(':user_id', $data['user_id']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updatePersonalInfo($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        first_name = :first_name, middle_name = :middle_name, last_name = :last_name, 
        gender = :gender, fb_account_name = :fb_account_name,
        contact_number = :contact_number, birthdate = :birthdate, address = :address
         WHERE id = :user_id 
      '
    );

    $this->db->bind(':first_name', $data['first_name']);
    $this->db->bind(':middle_name', $data['middle_name']);
    $this->db->bind(':last_name', $data['last_name']);
    $this->db->bind(':gender', $data['gender']);
    $this->db->bind(':fb_account_name', $data['fb_account_name']);
    $this->db->bind(':contact_number', $data['contact_number']);
    $this->db->bind(':birthdate', $data['birthdate']);
    $this->db->bind(':address', $data['address']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updateClinicInfo($data)
  {
    $this->db->query(
      'UPDATE clinics 
       SET
        name = :name, street = :street, district = :district, 
        city = :city, contact_number = :contact_number
        WHERE id = :user_id 
      '
    );

    $this->db->bind(':name', $data['clinic_name']);
    $this->db->bind(':street', $data['clinic_street']);
    $this->db->bind(':district', $data['clinic_district']);
    $this->db->bind(':city', $data['clinic_city']);
    $this->db->bind(':contact_number', $data['clinic_contact_number']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updateEmergencyInfo($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        emergency_person_name = :emergency_person_name, 
        emergency_address = :emergency_address, 
        emergency_contact_number = :emergency_contact_number
       WHERE id = :user_id 
      '
    );

    $this->db->bind(':emergency_person_name', $data['emergency_person_name']);
    $this->db->bind(':emergency_address', $data['emergency_address']);
    $this->db->bind(':emergency_contact_number', $data['emergency_contact_number']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updateDuesInfo($data)
  {
    $this->db->query(
      'UPDATE users 
      SET
          payment_option = :payment_option
      WHERE id = :user_id 
      '
    );

    $this->db->bind(':payment_option', $data['payment_option']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function updateProfileImage($data)
  {
    $this->db->query(
      'UPDATE users 
      SET
          profile_img_path = :profile_img_path
      WHERE id = :user_id 
      '
    );

    $this->db->bind(':profile_img_path', $data['profile_img_path']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function insertClinicInfo($data)
  {
    $this->db->query(
      'INSERT INTO clinics 
      (user_id, name, street, district, city, contact_number)
      VALUES
      (:user_id, :name, :street, :district, :city, :contact_number)
      '
    );

    $this->db->bind(':name', $data['clinic_name']);
    $this->db->bind(':street', $data['clinic_street']);
    $this->db->bind(':district', $data['clinic_district']);
    $this->db->bind(':city', $data['clinic_city']);
    $this->db->bind(':contact_number', $data['clinic_contact_number']);
    $this->db->bind(':user_id', $data['user_id']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }


  public function haveRows(array $columns, array $values)
  {
    if (sizeof($columns) !== sizeof($values)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $i = 0;
    $setString = '';
    foreach ($columns as $column) {
      if (++$i === count($columns)) {
        $setString .= $column . ' = :' . $column;
        break;
      }
      $setString .= $column . ' = :' . $column . ' AND ';
    }

    $sql = 'SELECT * FROM users WHERE ' . $setString;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->db->bind(':' . $columns[$i], $values[$i]);
    }

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function getRows()
  {
    $sql = 'SELECT * FROM users';
    $this->db->query($sql);

    $row = $this->db->resultSet();
    return $row;
  }

  public function getRowsByColumn($column, $value)
  {
    $sql = 'SELECT * FROM users WHERE ' . $column . ' = :' . $column;
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $row = $this->db->resultSet();

    return $row;
  }

  public function getRowByColumn($column, $value)
  {
    $sql = 'SELECT * FROM users WHERE ' . $column . ' = :' . $column;
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $row = $this->db->single();

    return $row;
  }

  public function getRowsWithColumns(array $columns, array $values)
  {
    if (sizeof($columns) !== sizeof($values)) {
      die('Error: columns and values must have the same length');
    }

    $i = 0;
    $setString = '';
    foreach ($columns as $column) {
      if (++$i === count($columns)) {
        $setString .= $column . ' = :' . $column;
        break;
      }
      $setString .= $column . ' = :' . $column . ' AND ';
    }

    $sql = 'SELECT * FROM users WHERE ' . $setString;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->db->bind(':' . $columns[$i], $values[$i]);
    }

    if ($this->db->execute()) {
      return $this->db->resultSet();
    } else {
      return false;
    }
  }


  public function find(array $selectedCols = [], array $filterCols = [], array $filterVals = [])
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table2 . ' WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    return $this->db->single();
  }

  public function findUserProfile(array $selectedCols = [], array $filterCols = [], array $filterVals = [])
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table2 . ' LEFT JOIN profiles on profiles.id = accounts.profile_id WHERE ' . $filters;

    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $this->placeholder($filterCols[$i]), $filterVals[$i]);
    }

    return $this->db->single();
  }

  public function getUserProfile(array $selectedCols = [], array $filterCols = [], array $filterVals = []): array
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table2 . ' LEFT JOIN profiles on profiles.id = accounts.profile_id WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $this->placeholder($filterCols[$i]), $filterVals[$i]);
    }

    return $this->db->resultSet();
  }

  public function hasRow(array $filterCols, array $filterVals)
  {
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  public function store2($cols, $vals)
  {
    if (sizeof($cols) !== sizeof($vals)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $placeholders = [];
    for ($i = 0; $i < sizeof($cols); $i++) {
      $placeholders[] = ':' . $cols[$i];
    }

    $this->db()->query(
      'INSERT INTO ' . $this->table2 . '
        (
          ' . join(',', $cols) . '
        ) 
      VALUES
        (
          ' . join(',', $placeholders) . '
        )
      '
    );

    for ($i = 0; $i < sizeof($cols); $i++) {
      $this->db->bind(':' . $cols[$i], $vals[$i]);
    }

    if ($this->db()->execute()) {
      $this->db()->query('SELECT * FROM accounts WHERE id = @@identity');

      return $this->db()->single();
    } else {
      return false;
    }
  }


  // Find user by email
  public function findUserByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    // Bind value
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Find user by email
  public function findUserByUsername($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email');
    // Bind value
    $this->db->bind(':email', $email);

    $row = $this->db->single();

    // Check row
    if ($this->db->rowCount() > 0) {
      return true;
    } else {
      return false;
    }
  }

  // Get User by ID
  public function getUserById($id)
  {
    $this->db->query('SELECT * FROM users WHERE id = :id');
    // Bind value
    $this->db->bind(':id', $id);

    $row = $this->db->single();

    return $row;
  }

  public function getRowWithValue($table, $column, $value)
  {
    $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = :' . $column;
    $this->db->query($sql);
    // Bind value
    $this->db->bind(':' . $column, $value);

    $row = $this->db->single();

    return $row;
  }

  function storeNewPassword($email)
  {
    $permitted_chars = uniqid();
    $offset = strlen($permitted_chars) - 5;
    $newPassword = substr(str_shuffle($permitted_chars), 0, $offset);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = 'UPDATE users SET new_password = :new_password WHERE email = :email';
    $this->db->query($sql);

    $this->db->bind(':new_password', $hashedPassword);
    $this->db->bind(':email', $email);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function storeNewEmail($data)
  {
    $sql = 'UPDATE users SET new_email = :new_email WHERE email = :current_email AND email_verified = true';
    $this->db->query($sql);

    $this->db->bind(':new_email', $data['email']);
    $this->db->bind(':current_email', $data['current_email']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function updateRowById($column, $value, $id)
  {
    $sql = 'UPDATE users SET ' . $column . ' = :' . $column . ' WHERE id = :id AND email_verified = true';
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function updateRowsById($columns, $values, $id)
  {
    if (sizeof($columns) !== sizeof($values)) {
      die('Error: columns and values must have the same length');
    }

    $i = 0;
    $setString = '';
    foreach ($columns as $column) {
      if (++$i === count($columns)) {
        $setString .= $column . ' = :' . $column;
        break;
      }
      $setString .= $column . ' = :' . $column . ', ';
    }

    $sql = 'UPDATE users SET ' . $setString . ' WHERE id = :id';
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->db->bind(':' . $columns[$i], $values[$i]);
    }
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  function updateUserById($column, $value, $id)
  {
    $sql = 'UPDATE users SET ' . $column . ' = :' . $column . ' WHERE id = :id';
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function updateAuthCredentials($columns, $values, $id)
  {
    $sql = 'UPDATE users SET ' . $columns['access_token'] . ' = :access_token' . ',' . $columns['auth_id'] . ' = :auth_id WHERE id = :id';
    $this->db->query($sql);

    $this->db->bind(':access_token', $values['access_token']);
    $this->db->bind(':auth_id', $values['auth_id']);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
}
