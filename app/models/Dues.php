<?php
class Dues extends Model
{
  public function __construct()
  {
    $this->table = 'dues';
    $this->db = new Database;
  }


  public function getDatatable3($columns, $filters)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT SUM(' . $this->table . '.amount) AS total_filtered_amount FROM ' .
      $this->table . ' LEFT JOIN profiles ON profiles.id = ' .
      $this->table . '.profile_id WHERE 1 ' .
      $filters;

    $this->db->query($sql);

    return $this->db->single();
  }

  public function getDatatable2($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table . ' LEFT JOIN profiles ON profiles.id = ' .
      $this->table . '.profile_id LEFT JOIN accounts ON accounts.profile_id = ' .
      $this->table . '.profile_id WHERE 1 ' .
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
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN profiles ON profiles.id = ' . $this->table . '.profile_id';
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllWithFilters2($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN profiles ON profiles.id = ' . $this->table . '.profile_id LEFT JOIN accounts ON accounts.profile_id = ' . $this->table . '.profile_id WHERE 1 ' . $filters;
    $this->db->query($sql);

    return $this->db->single();
  }

  public function getPDARemittanceDatatable($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table . ' LEFT JOIN profiles ON profiles.id = ' .
      $this->table . '.profile_id LEFT JOIN accounts ON accounts.profile_id = ' .
      $this->table . '.profile_id WHERE 1 ' .
      $filters . ' GROUP BY profiles.prc_number ORDER BY ' .
      $orderColumn . ' ' .
      $orderType . ' LIMIT ' .
      $limitRow . ',' .
      $limitPerpage;

    $this->db->query($sql);

    return $this->db->resultSet();
  }
  function countAllPDARemittance()
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN profiles ON profiles.id = ' . $this->table . '.profile_id GROUP BY profiles.prc_number';
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllPDARemittanceWithFilters($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN profiles ON profiles.id = ' . $this->table . '.profile_id LEFT JOIN accounts ON accounts.profile_id = ' . $this->table . '.profile_id WHERE 1 ' . $filters . ' GROUP BY profiles.prc_number';
    $this->db->query($sql);

    return $this->db->single();
  }

  public function store($data)
  {
    $this->db->query(
      'INSERT INTO ' . $this->table . '
          (
            profile_id, prc_number, type, amount, channel, or_number, remarks, date_posted
          ) 
        VALUES
          (
            :profile_id, :prc_number, :type, :amount, :channel, :or_number, :remarks, :date_posted
          )
        '
    );

    $this->db->bind(':profile_id', $data['profile_id']);
    $this->db->bind(':prc_number', $data['prc_number']);
    $this->db->bind(':type', $data['type']);
    $this->db->bind(':amount', $data['amount']);
    $this->db->bind(':channel', $data['channel']);
    $this->db->bind(':or_number', $data['or_number']);
    $this->db->bind(':date_posted', $data['date_posted']);
    $this->db->bind(':remarks', $data['remarks']);

    if ($this->db->execute()) {
      $this->db->query('SELECT * FROM ' . $this->table . ' WHERE id = @@identity');

      return $this->db->single();
    } else {
      return false;
    }
  }

  public function store2($data)
  {
    $this->db()->query(
      'INSERT INTO ' . $this->table . '
        (
          prc_number, amount, type, channel, or_number, date_posted, remarks, profile_id
        ) 
      VALUES
        (
          :prc_number, :amount, :type, :channel, :or_number, :date_posted, :remarks, :profile_id
        )
      '
    );

    $this->db->bind(':prc_number', $this->column($data['0']));
    $this->db->bind(':amount', $this->column($data['1']));
    $this->db->bind(':type', $this->column($data['2']));
    $this->db->bind(':channel', $this->column($data['3']));
    $this->db->bind(':or_number', $this->column($data['4']));
    $this->db->bind(':date_posted', $this->column($data['5']));
    $this->db->bind(':remarks', $this->column($data['6']));
    $this->db->bind(':profile_id', $this->column($data['profile_id']));

    if ($this->db()->execute()) {
      $this->db()->query('SELECT * FROM ' . $this->table . ' WHERE id = @@identity');

      return $this->db()->single();
    } else {
      return false;
    }
  }

  public function store3($cols, $vals)
  {
    if (sizeof($cols) !== sizeof($vals)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $placeholders = [];
    for ($i = 0; $i < sizeof($cols); $i++) {
      $placeholders[] = ':' . $cols[$i];
    }

    $this->db()->query(
      'INSERT INTO ' . $this->table . '
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
      $this->db()->query('SELECT * FROM ' . $this->table . ' WHERE id = @@identity');

      return $this->db()->single();
    } else {
      return false;
    }
  }

  public function insertMultiple($vals): bool
  {
    $sql = 'INSERT INTO ' . $this->table . ' (profile_id, prc_number, amount, type, channel, or_number, date_posted, remarks) VALUES ';
    $insertQuery = array();
    $insertData = array();
    $n = 0;
    foreach ($vals as $row) {
      $insertQuery[] = '(:profile_id' . $n . ', :prc_number' . $n . ', :amount' . $n . ', :type' . $n . ', :channel' . $n . ',:or_number' . $n . ', :date_posted' . $n . ', :remarks' . $n . ')';
      $insertData['profile_id' . $n] = empty(trim($row['profile_id'] ?? '')) ? null : trim($row['profile_id']);
      $insertData['prc_number' . $n] = empty(trim($row['prc_number'] ?? '')) ? null : trim($row['prc_number']);
      $insertData['amount' . $n] = empty(trim($row['amount'] ?? '')) ? null : trim($row['amount']);
      $insertData['type' . $n] = empty(trim($row['paid_to'] ?? '')) ? null : trim($row['paid_to']);
      $insertData['channel' . $n] = empty(trim($row['channel'] ?? '')) ? null : trim($row['channel']);
      $insertData['or_number' . $n] = empty(trim($row['or_number'] ?? '')) ? null : trim($row['or_number']);
      $insertData['date_posted' . $n] = empty(trim($row['date_posted'] ?? '')) ? null : trim($row['date_posted']);
      $insertData['remarks' . $n] = empty(trim($row['remarks'] ?? '')) ? null : trim($row['remarks']);
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

  public function getAllDuesByUserId($idType, $id)
  {
    $this->db->query('SELECT * FROM dues WHERE ' . $idType . ' = :id ORDER BY date_created');
    $this->db->bind(':id', $id);

    $row = $this->db->resultSet();
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

  public function getRows()
  {
    $sql = 'SELECT * FROM clinics';
    $this->db->query($sql);

    $row = $this->db->resultSet();
    return $row;
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
  public function get(array $selectedCols = [], array $filterCols = [], array $filterVals = [])
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

    $sql = 'SELECT ' . join(',', $selects) . ' FROM ' . $this->table . ' WHERE ' . $filterCol . ' IN (' . $placeholders . ')';
    $this->db->query($sql);

    $this->db->execute($filterVals);

    if ($this->db->rowCount() > 0) {
      return $this->db->resultSet();
    } else {
      return false;
    }
  }

  public function update($columns, $values, $idTypes, $ids)
  {
    return $this->db->update2($this->table, $columns, $values, $idTypes, $ids);
  }

  /* JOINS */
  public function getUserYearlyPayments($data)
  {
    $sql = "SELECT YEAR(" . $this->table . ".date_posted) AS year, MONTH(" . $this->table . ".date_posted) AS month, 
    GROUP_CONCAT(dcc.dcc_amount SEPARATOR ', ') AS dcc, GROUP_CONCAT(dcc.dcc_or SEPARATOR ', ') AS 'dcc_or', 
    GROUP_CONCAT(pda.pda_amount SEPARATOR ', ') AS pda, GROUP_CONCAT(pda.pda_or SEPARATOR ', ') AS 'pda_or',
    " . $this->table . ".remarks
    FROM " . $this->table . "
    LEFT JOIN (
        SELECT id AS pda_id, amount AS pda_amount, or_number AS pda_or 
        FROM " . $this->table . "
        WHERE type = 'pda'
    ) AS pda 
      ON " . $this->table . ".id = pda.pda_id 
    LEFT JOIN (
        SELECT id AS dcc_id, amount AS dcc_amount, or_number AS dcc_or 
        FROM " . $this->table . " 
        WHERE type = 'dcc'
    ) AS dcc 
      ON " . $this->table . ".id = dcc.dcc_id 
    WHERE type IN('dcc', 'pda') 
    AND profile_id = :user_id
    GROUP BY YEAR(" . $this->table . ".date_posted)";

    $this->db->query($sql);
    $this->db->bind(':user_id', $data['user_id']);

    $row = $this->db->resultSet();
    return $row;
  }

  // public function getTotalAmountBetweenYears($startYear, $endYear, $startMonth = null, $endMonth = null)
  // {
  //   $startMonth == null ? $startMonth = date('m') : $startMonth;
  //   $endMonth == null ? $endMonth = date('m') : $startMonth;

  //   $sql = 'SELECT users.*, dues.*, users.id AS user_id, users.account_status AS is_active
  //   FROM users 
  //     INNER JOIN dues on users.id = dues.user_id 
  //   WHERE dues.date_created 
  //     BETWEEN CONCAT(:start_year,"-",:start_month,"-01") 
  //       AND CONCAT(:end_year,"-",:end_month,"-01")';

  //   $this->db->query($sql);
  //   $this->db->bind(':start_month', $startMonth);
  //   $this->db->bind(':start_year', $startYear);
  //   $this->db->bind(':end_month', $endMonth);
  //   $this->db->bind(':end_year', $endYear);

  //   $row = $this->db->resultSet();
  //   return $row;
  // }
  // public function getPaymentsByUserAndType($user_id, $type, $startYear, $endYear)
  // {
  //   $sql = 'SELECT users.id as user_id, dues.amount, dues.channel, dues.type, dues.or_number, dues.date_created as date from users INNER JOIN dues on users.id = dues.user_id WHERE YEAR(dues.date_created) BETWEEN :start_year AND :end_year AND users.id = :user_id AND dues.type = :type';
  //   $this->db->query($sql);
  //   $this->db->bind(':user_id', $user_id);
  //   $this->db->bind(':type', $type);
  //   $this->db->bind(':start_year', $startYear);
  //   $this->db->bind(':end_year', $endYear);

  //   $row = $this->db->resultSet();
  //   return $row;
  // }

  // public function getListOfMembersWithGroupedPayments()
  // {
  //   $sql = "SELECT users.id, users.first_name, users.middle_name, users.last_name, users.prc_number, CONCAT(GROUP_CONCAT(pda.pda_amount SEPARATOR ', '), ' ', IFNULL(CONCAT('(', users.status_remarks , ')'), '')) AS payments
  //   FROM dues 
  //       LEFT JOIN users ON users.id = dues.user_id 
  //   LEFT JOIN (
  //       SELECT id AS pda_id, CONCAT(YEAR(date_created), IFNULL(CONCAT(' (#', or_number , ')'), '')) AS pda_amount
  //       FROM dues 
  //       WHERE type = 'pda'
  //   ) AS pda     
  //     ON dues.id = pda.pda_id 
  //   GROUP BY dues.user_id";

  //   $this->db->query($sql);

  //   $row = $this->db->resultSet();
  //   return $row;
  // }
}
