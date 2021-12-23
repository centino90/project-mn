<?php
/*
   * PDO Database Class
   * Connect to database
   * Create prepared statements
   * Bind values
   * Return rows and results
   */
class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;

  private $dbh;
  private $stmt;
  private $error;

  public function __construct()
  {
    // Set DSN
    $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
    $options = array(
      PDO::ATTR_PERSISTENT => true,
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    // Create PDO instance
    try {
      $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
    } catch (PDOException $e) {
      // $this->error = $e->getMessage();
    }
  }

  // Prepare statement with query
  public function query($sql)
  {
    $this->stmt = $this->dbh->prepare($sql);
  }

  // Bind values
  public function bind($param, $value, $type = null)
  {
    if (is_null($type)) {
      switch (true) {
        case is_int($value):
          $type = PDO::PARAM_INT;
          break;
        case is_bool($value):
          $type = PDO::PARAM_BOOL;
          break;
        case is_null($value):
          $type = PDO::PARAM_NULL;
          break;
        default:
          $type = PDO::PARAM_STR;
      }
    }

    $this->stmt->bindValue($param, $value, $type);
  }

  // Execute the prepared statement
  public function execute()
  {
    return $this->stmt->execute();
  }

  // Get result set as array of objects
  public function resultSet()
  {
    $this->execute();
    return $this->stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Get single record as object
  public function single()
  {
    $this->execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
  }

  // Get row count
  public function rowCount()
  {
    $this->execute();
    return $this->stmt->rowCount();
  }

  function updateRowById($table, $column, $value, $id)
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

  function selectAllWithSingleJoin($primaryTable, $secondaryTable, $foreignKey, $referenceKey, $columns, $orderType = 'ASC')
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM '
      . $primaryTable . ' INNER JOIN '
      . $secondaryTable . ' ON '
      . $referenceKey . ' = '
      . $foreignKey . ' ORDER BY '
      . $primaryTable . '.created_at '
      . $orderType;

    $this->query($sql);

    return $this->resultSet();
  }
  function selectWithSingleJoin($id, $idType, $primaryTable, $secondaryTable, $foreignKey, $referenceKey, $columns, $orderType = 'ASC')
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' . $selected . ' FROM '
      . $primaryTable . ' INNER JOIN '
      . $secondaryTable . ' ON '
      . $referenceKey . ' = '
      . $foreignKey . ' WHERE '
      . $idType . ' = :id ORDER BY '
      . $primaryTable . '.created_at '
      . $orderType;

    $this->query($sql);
    $this->bind(':id', $id);

    return $this->single();
  }
  function selectAll($table, $columns = [], $values = [], $includeAdmin = true)
  {
    if (sizeof($columns) !== sizeof($values)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $i = 0;
    $setString = '';
    if (!empty($columns) && !empty($values)) {
      $setString.= 'WHERE ';
      foreach ($columns as $column) {
        if (++$i === count($columns)) {
          $setString .= $column . ' = :' . $column;
          break;
        }
        $setString .= $column . ' = :' . $column . ' AND ';
      }

      $setString .= ' AND role != "superadmin" ';
    }

    $sql = 'SELECT * FROM ' . $table . ' ' . $setString;
    $this->query($sql);

    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->bind(':' . $columns[$i], $values[$i]);
    }

    return $this->resultSet();
  }

  function select($idType, $id, $table, $columns = [], $values = [], $includeAdmin = true)
  {
    if (sizeof($columns) !== sizeof($values)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $i = 0;
    $setString = '';
    if (!empty($columns) && !empty($values)) {
      $setString.= 'WHERE ';
      foreach ($columns as $column) {
        if (++$i === count($columns)) {
          $setString .= $column . ' = :' . $column;
          break;
        }
        $setString .= $column . ' = :' . $column . ' AND ';
      }

      $setString .= ' AND role != "superadmin" ';
    }

    $sql = 'SELECT * FROM ' . $table . ' ' . $setString;
    $this->query($sql);

    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->bind(':' . $columns[$i], $values[$i]);
    }

    return $this->resultSet();

    $sql = 'SELECT * FROM ' . $table;
    $this->query($sql);

    return $this->resultSet();
  }

  function insert($table, $column, $value, $id)
  {
  }

  function update($table, $columns, $values, $idType, $id)
  {
    if (sizeof($columns) !== sizeof($values)) {
      throw new Error('Error: columns and values must have the same length');
    }

    // append and fromat update string
    $i = 0;
    $setString = '';
    foreach ($columns as $column) {
      if (++$i === count($columns)) {
        $setString .= $column . ' = :' . $column;
        break;
      }
      $setString .= $column . ' = :' . $column . ', ';
    }

    $sql = 'UPDATE ' . $table . ' SET ' . $setString . ' WHERE ' . $idType . ' = :id';
    $this->query($sql);

    // bind parameterized columns and id
    for ($i = 0; $i < sizeof($columns); $i++) {
      $this->bind(':' . $columns[$i], $values[$i]);
    }
    $this->bind(':id', $id);

    if ($this->execute()) {
      return true;
    } else {
      return false;
    }
  }

  function delete()
  {
  }

  function countAll($table)
  {
    $sql = 'SELECT count(*) as count FROM ' . $table;
    $this->query($sql);

    return $this->single();
  }
  function countAllWithFilters($table, $filters)
  {
    $sql = 'SELECT count(*) as count FROM ' . $table . ' WHERE 1 ' . $filters;
    $this->query($sql);

    return $this->single();
  }
  function dataTable($table, $columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    $selected = join(',', $columns);
    $sql = 'SELECT ' .
      $selected . ' FROM ' .
      $table . ' WHERE 1 ' .
      $filters . ' ORDER BY ' .
      $orderColumn . ' ' .
      $orderType . ' LIMIT ' .
      $limitRow . ',' .
      $limitPerpage;

    $this->query($sql);

    return $this->resultSet();
  }
}
