<?php
class Profile extends Model
{
  public $db;
  public $table = 'profiles';
  public $primaryKey = 'id';
  public $joinedPrimarykey = '';

  public function __construct()
  {
    $this->db = new Database;
    $this->joinedPrimarykey =  $this->table . '.' . $this->primaryKey;
  }

  public function getProfileUser(array $selectedCols = ['*'], array $filterCols = [1], array $filterVals = [1]): array
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' LEFT JOIN accounts on accounts.profile_id = profiles.id WHERE profiles.first_name IS NOT NULL AND profiles.last_name IS NOT NULL AND ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $this->placeholder($filterCols[$i]), $filterVals[$i]);
    }

    return $this->db->resultSet();
  }

  public function findProfileUser(array $selectedCols = ['*'], array $filterCols = [1], array $filterVals = [1])
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' LEFT JOIN accounts on accounts.profile_id = profiles.id LEFT JOIN (SELECT or_number, date_posted AS cd_dates, profile_id FROM dues GROUP BY dues.profile_id, date_posted) cd_dues ON cd_dues.profile_id = profiles.id WHERE profiles.first_name IS NOT NULL AND profiles.last_name IS NOT NULL AND ' . $filters . ' GROUP BY profiles.id ORDER BY profiles.last_name';
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $this->placeholder($filterCols[$i]), $filterVals[$i]);
    }

    return $this->db->single();
  }

  public function storeImport($data)
  {
    $this->db->query(
      'INSERT INTO ' . $this->table . '
        (first_name, middle_name, last_name, birthdate, address,contact_number, gender, fb_account_name, prc_number, prc_registration_date,prc_expiration_date, field_practice, type_practice, clinic_name, clinic_street,clinic_district, clinic_city, clinic_contact, emergency_person_name, emergency_address, emergency_contact_number) 
      VALUES
        (:first_name,:middle_name,:last_name,:birthdate,:address,:contact_number,:gender,:fb_account_name,:prc_number,:prc_registration_date,:prc_expiration_date,:field_practice,:type_practice,:clinic_name,:clinic_street,:clinic_district,:clinic_city,:clinic_contact,:emergency_person_name,:emergency_address,:emergency_contact_number)
      '
    );

    $this->db->bind(':first_name', trim($data['0'] ?? null));
    $this->db->bind(':middle_name', trim($data['1'] ?? null));
    $this->db->bind(':last_name', trim($data['2'] ?? null));
    $this->db->bind(':birthdate', trim($data['3'] ?? null));
    $this->db->bind(':address', trim($data['4'] ?? null));
    $this->db->bind(':contact_number', trim($data['5'] ?? null));
    $this->db->bind(':gender', trim($data['6'] ?? null));
    $this->db->bind(':fb_account_name', trim($data['7'] ?? null));
    $this->db->bind(':prc_number', trim($data['8'] ?? null));
    $this->db->bind(':prc_registration_date', trim($data['9'] ?? null));
    $this->db->bind(':prc_expiration_date', trim($data['10'] ?? null));
    $this->db->bind(':field_practice', trim($data['11'] ?? null));
    $this->db->bind(':type_practice', trim($data['12'] ?? null));
    $this->db->bind(':clinic_name', trim($data['13'] ?? null));
    $this->db->bind(':clinic_street', trim($data['14'] ?? null));
    $this->db->bind(':clinic_district', trim($data['15'] ?? null));
    $this->db->bind(':clinic_city', trim($data['16'] ?? null));
    $this->db->bind(':clinic_contact', trim($data['17'] ?? null));
    $this->db->bind(':emergency_person_name', trim($data['18'] ?? null));
    $this->db->bind(':emergency_address', trim($data['19'] ?? null));
    $this->db->bind(':emergency_contact_number', trim($data['20'] ?? null));

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function insertMultiple($vals): bool
  {
    $sql = 'INSERT INTO profiles (first_name, middle_name, last_name, birthdate, address,contact_number, gender, fb_account_name, prc_number, prc_registration_date,prc_expiration_date, field_practice, type_practice, clinic_name, clinic_street,clinic_district, clinic_city, clinic_contact, emergency_person_name, emergency_address, emergency_contact_number) VALUES ';
    $insertQuery = array();
    $insertData = array();
    $n = 0;
    foreach ($vals as $row) {
      $insertQuery[] = '(:first_name' . $n . ', :middle_name' . $n . ', :last_name' . $n . ', :birthdate' . $n . ', :address' . $n . ',:contact_number' . $n . ', :gender' . $n . ', :fb_account_name' . $n . ', :prc_number' . $n . ', :prc_registration_date' . $n . ',:prc_expiration_date' . $n . ', :field_practice' . $n . ', :type_practice' . $n . ', :clinic_name' . $n . ', :clinic_street' . $n . ',:clinic_district' . $n . ', :clinic_city' . $n . ', :clinic_contact' . $n . ', :emergency_person_name' . $n . ', :emergency_address' . $n . ', :emergency_contact_number' . $n . ')';
      $insertData['first_name' . $n] = empty($row['first_name']) ? null : trim($row['first_name']);
      $insertData['middle_name' . $n] = empty(trim($row[1] ?? '')) ? null : trim($row[1]);
      $insertData['last_name' . $n] = empty($row['last_name']) ? null : $row['last_name'];
      $insertData['birthdate' . $n] = empty($row['birthdate']) ? null : $row['birthdate'];
      $insertData['address' . $n] = empty(trim($row[4] ?? '')) ? null : trim($row[4]);
      $insertData['contact_number' . $n] = empty(trim($row[5] ?? '')) ? null : trim($row[5]);
      $insertData['gender' . $n] = empty(trim($row[6] ?? '')) ? null : trim($row[6]);
      $insertData['fb_account_name' . $n] = empty(trim($row[7] ?? '')) ? null : trim($row[7]);
      $insertData['prc_number' . $n] = empty($row['prc_number']) ? null : $row['prc_number'];
      $insertData['prc_registration_date' . $n] = empty(trim($row[9] ?? '')) ? null : trim($row[9]);
      $insertData['prc_expiration_date' . $n] = empty(trim($row[10] ?? '')) ? null : trim($row[10]);
      $insertData['field_practice' . $n] = empty(trim($row[11] ?? '')) ? null : trim($row[11]);
      $insertData['type_practice' . $n] = empty(trim($row[12] ?? '')) ? null : trim($row[12]);
      $insertData['clinic_name' . $n] = empty(trim($row[13] ?? '')) ? null : trim($row[13]);
      $insertData['clinic_street' . $n] = empty(trim($row[14] ?? '')) ? null : trim($row[14]);
      $insertData['clinic_district' . $n] = empty(trim($row[15] ?? '')) ? null : trim($row[15]);
      $insertData['clinic_city' . $n] = empty(trim($row[16] ?? '')) ? null : trim($row[16]);
      $insertData['clinic_contact' . $n] = empty(trim($row[17] ?? '')) ? null : trim($row[17]);
      $insertData['emergency_person_name' . $n] = empty(trim($row[18] ?? '')) ? null : trim($row[18]);
      $insertData['emergency_address' . $n] = empty(trim($row[19] ?? '')) ? null : trim($row[19]);
      $insertData['emergency_contact_number' . $n] = empty(trim($row[20] ?? '')) ? null : trim($row[20]);
      $n++;
    }

    if (!empty($insertQuery)) {
      $sql .= implode(', ', $insertQuery);
      $this->db->query($sql);
      if ($this->db->execute($insertData)) {
        return true;
      } else {
        return false;
      }
    }

    return false;
  }

  private function placeholders($text, $count = 0, $separator = ",")
  {
    $result = array();
    if ($count > 0) {
      for ($x = 0; $x < $count; $x++) {
        $result[] = $text;
      }
    }

    return implode($separator, $result);
  }

  public function getDatatable2($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table . ' LEFT JOIN (SELECT or_number, date_posted AS cd_dates, profile_id FROM dues WHERE deleted_at IS NULL AND type = "DCC" GROUP BY dues.profile_id, date_posted) cd_dues ON cd_dues.profile_id = profiles.id '
      . ' LEFT JOIN (SELECT or_number, date_posted AS pda_dates, profile_id FROM dues WHERE deleted_at IS NULL AND type = "PDA" GROUP BY dues.profile_id, date_posted) pda_dues ON pda_dues.profile_id = profiles.id '
      . ' LEFT JOIN accounts ON accounts.profile_id = profiles.id '
      . ' WHERE 1 ' .
      $filters . ' GROUP BY profiles.id ORDER BY ' .
      $orderColumn . ' ' .
      $orderType . ' LIMIT ' .
      $limitRow . ',' .
      $limitPerpage;

    $this->db->query($sql);

    return $this->db->resultSet();
  }
  function countAll2()
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table;
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllWithFilters2($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' WHERE 1 ' . $filters;
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

  public function get(array $selectedCols = [], array $filterCols = [], array $filterVals = []): array
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    return $this->db->resultSet();
  }
  public function find(array $selectedCols = [], array $filterCols = [], array $filterVals = [])
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' WHERE ' . $filters;
    $this->db->query($sql);

    for ($i = 0; $i < sizeof($filterCols); $i++) {
      $this->db->bind(':' . $filterCols[$i], $filterVals[$i]);
    }

    return $this->db->single();
  }

  public function hasRow(array $filterCols, array $filterVals): bool
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

  public function whereIn(array $selects, $filterCol, array $filterVals)
  {
    $placeholders = implode(',', array_fill(0, sizeof($filterVals), '?'));

    // dd($filterVals);

    $sql = 'SELECT ' . join(',', $selects) . ' FROM ' . $this->table . ' WHERE ' . $filterCol . ' IN (' . $placeholders . ')';
    $this->db->query($sql);

    $this->db->execute($filterVals);

    if ($this->db->rowCount() > 0) {
      return $this->db->resultSet();
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
      'INSERT INTO profiles
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
      $this->db()->query('SELECT * FROM profiles WHERE id = @@identity');

      return $this->db()->single();
    } else {
      return false;
    }
  }

  public function update3($columns, $values, $idTypes, $ids)
  {
    return $this->db->update2($this->table, $columns, $values, $idTypes, $ids);
  }
}
