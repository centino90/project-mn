<?php
class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database;
  }

  public function userToClinic()
  {
    $sql = 'SELECT users.*, clinics.name as clinic_name, clinics.district as clinic_district, clinics.street as clinic_street, clinics.city as clinic_city, clinics.contact_number as clinic_contact_no FROM `users` LEFT JOIN clinics on users.id = clinics.user_id';
    $this->db->query($sql);

    $row = $this->db->resultSet();
    return $row;
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

    $this->db->bind(':first_name', $data['first_name'] ?? null);
    $this->db->bind(':last_name', $data['last_name'] ?? null);
    $this->db->bind(':email', $data['email'] ?? null);
    $this->db->bind(':role', $data['role'] ?? 'member');
    $this->db->bind(':email_vkey', $emailVkey ?? null);
    $this->db->bind(':password', $data['password'] ?? null);
    $this->db->bind(':fb_user_id', $data['fb_user_id'] ?? null);
    $this->db->bind(':fb_access_token', $data['fb_access_token'] ?? null);
    $this->db->bind(':google_user_id', $data['google_user_id'] ?? null);
    $this->db->bind(':google_access_token', $data['google_access_token'] ?? null);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }
  public function regenerateVkey($vkeyType, $idType, $id)
  {
    $randomVkey = uniqid();

    $this->db->query(
      'UPDATE users 
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

  public function deleteUser($idType, $id, $isEmailVerified = false, $isActive = false)
  {
    $this->db->query(
      'DELETE FROM users WHERE ' . $idType . ' = :id AND email_verified = :email_verified AND is_active = :is_active'
    );

    $this->db->bind(':id', $id);
    $this->db->bind(':email_verified', $isEmailVerified);
    $this->db->bind(':is_active', $isActive);

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

  public function verifyEmail($data)
  {
    $this->db->query(
      'UPDATE users 
         SET
          email_verified = :email_verified
           WHERE id = :user_id AND email_vkey = :email_vkey
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


    // return $row;
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

  function resetPasswordAndReturnUnencryptedVersion($id, $emailVkey)
  {
    $permitted_chars = uniqid();
    $offset = strlen($permitted_chars) - 5;
    $newPassword = substr(str_shuffle($permitted_chars), 0, $offset);
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

    $sql = 'UPDATE users 
            SET 
              password = :password 
              WHERE id = :id AND email_vkey = :email_vkey
              ';
    $this->db->query($sql);

    $this->db->bind(':password', $hashedPassword);
    $this->db->bind(':id', $id);
    $this->db->bind(':email_vkey', $emailVkey);

    if ($this->db->execute()) {
      return $newPassword;
    } else {
      return false;
    }
  }
}
