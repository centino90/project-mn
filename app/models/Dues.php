<?php
class Dues
{
  private $db;
  private $table = 'dues';

  public function __construct()
  {
    $this->db = new Database;
  }

  public function getDatatable($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM ' .
      $this->table . ' LEFT JOIN users ON users.id = ' .
      $this->table . '.user_id WHERE 1 ' .
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
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN users ON users.id = ' . $this->table . '.user_id';
    $this->db->query($sql);

    return $this->db->single();
  }
  function countAllWithFilters($filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $this->table . ' LEFT JOIN users ON users.id = ' . $this->table . '.user_id WHERE 1 ' . $filters;
    $this->db->query($sql);

    return $this->db->single();
  }

  // inherited methods
  public function store($data)
  {
    // select user by prc_number
    $this->db->query(
      'SELECT * FROM users WHERE prc_number = :prc_number'
    );
    $this->db->bind(':prc_number', $data['user_id']);
    $row = $this->db->single();

    // insert dues on user containing prc_number
    if ($row) {
      $this->db->query(
        'INSERT INTO dues 
          (
            user_id, type, amount, channel, or_number, remarks, date_created
          ) 
        VALUES
          (
            :user_id, :type, :amount, :channel, :or_number, :remarks, :date
          )
        '
      );

      $this->db->bind(':user_id', $row->id);
      $this->db->bind(':type', $data['type']);
      $this->db->bind(':amount', $data['amount']);
      $this->db->bind(':channel', $data['channel']);
      $this->db->bind(':or_number', $data['or_number']);
      $this->db->bind(':remarks', $data['remarks']);
      $this->db->bind(':date', $data['date']);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }
  public function storeByPrcNumber($data)
  {
    // select user by prc_number
    $this->db->query(
      'SELECT * FROM users WHERE prc_number = :prc_number'
    );
    $this->db->bind(':prc_number', $data[0]);
    $row = $this->db->single();

    // insert dues on user containing prc_number
    if ($row) {
      $this->db->query(
        'INSERT INTO dues 
          (
            user_id, type, amount, channel, or_number, remarks, date_created
          ) 
        VALUES
          (
            :user_id, :type, :amount, :channel, :or_number, :remarks, :date
          )
        '
      );

      $this->db->bind(':user_id', $row->id);
      $this->db->bind(':type', $data[1]);
      $this->db->bind(':amount', $data[2]);
      $this->db->bind(':channel', $data[3]);
      $this->db->bind(':or_number', $data[4]);
      $this->db->bind(':remarks', $data[5]);
      $this->db->bind(':date', $data[6]);

      if ($this->db->execute()) {
        return true;
      } else {
        return false;
      }
    }
  }

  public function updateAdditionalInfo($data)
  {
    $this->db->query(
      'UPDATE users 
       SET
        middle_name = :middle_name, prc_number = :prc_number, contact_number = :contact_number, birthdate = :birthdate, address = :address
      '
    );

    $this->db->bind(':middle_name', $data['middle_name']);
    $this->db->bind(':prc_number', $data['prc_number']);
    $this->db->bind(':contact_number', $data['contact_number']);
    $this->db->bind(':birthdate', $data['birthdate']);
    $this->db->bind(':address', $data['address']);

    // Execute
    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  // Get User by ID
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

  public function updateRowById($table, $column, $value, $id)
  {
    $sql = 'UPDATE ' . $table . ' SET ' . $column . ' = :' . $column . ' WHERE id = :id';
    $this->db->query($sql);

    $this->db->bind(':' . $column, $value);
    $this->db->bind(':id', $id);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getTotalAmountBetweenYears($startYear, $endYear, $startMonth = null, $endMonth = null)
  {
    $startMonth == null ? $startMonth = date('m') : $startMonth;
    $endMonth == null ? $endMonth = date('m') : $startMonth;

    $sql = 'SELECT users.*, dues.*, users.id AS user_id, IF(users.is_active = 1, "active", "inactive") AS is_active
    FROM users 
      INNER JOIN dues on users.id = dues.user_id 
    WHERE dues.date_created 
      BETWEEN CONCAT(:start_year,"-",:start_month,"-01") 
        AND CONCAT(:end_year,"-",:end_month,"-01")';

    $this->db->query($sql);
    $this->db->bind(':start_month', $startMonth);
    $this->db->bind(':start_year', $startYear);
    $this->db->bind(':end_month', $endMonth);
    $this->db->bind(':end_year', $endYear);

    $row = $this->db->resultSet();
    return $row;
  }
  public function getPaymentsByUserAndType($user_id, $type, $startYear, $endYear)
  {
    $sql = 'SELECT users.id as user_id, dues.amount, dues.channel, dues.type, dues.or_number, dues.date_created as date from users INNER JOIN dues on users.id = dues.user_id WHERE YEAR(dues.date_created) BETWEEN :start_year AND :end_year AND users.id = :user_id AND dues.type = :type';
    $this->db->query($sql);
    $this->db->bind(':user_id', $user_id);
    $this->db->bind(':type', $type);
    $this->db->bind(':start_year', $startYear);
    $this->db->bind(':end_year', $endYear);

    $row = $this->db->resultSet();
    return $row;
  }


  /* JOINS */
  public function getUserYearlyPayments($data)
  {
    $sql = "SELECT YEAR(dues.date_created) AS year, 
    GROUP_CONCAT(dcc.dcc_amount SEPARATOR ', ') AS dcc, GROUP_CONCAT(dcc.dcc_or SEPARATOR ', ') AS 'dcc_or', 
    GROUP_CONCAT(pda.pda_amount SEPARATOR ', ') AS pda, GROUP_CONCAT(pda.pda_or SEPARATOR ', ') AS 'pda_or',
    dues.remarks
    FROM dues 
    LEFT JOIN (
        SELECT id AS pda_id, amount AS pda_amount, or_number AS pda_or 
        FROM dues 
        WHERE type = 'pda'
    ) AS pda 
      ON dues.id = pda.pda_id 
    LEFT JOIN (
        SELECT id AS dcc_id, amount AS dcc_amount, or_number AS dcc_or 
        FROM dues 
        WHERE type = 'dcc'
    ) AS dcc 
      ON dues.id = dcc.dcc_id 
    WHERE type IN('dcc', 'pda') 
    AND user_id = :user_id
    GROUP BY YEAR(dues.date_created)";

    $this->db->query($sql);
    $this->db->bind(':user_id', $data['user_id']);

    $row = $this->db->resultSet();
    return $row;
  }
}
