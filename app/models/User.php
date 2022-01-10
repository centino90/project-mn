<?php
class User extends Model
{
  public $db;
  public $table = 'accounts';
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

    $sql = 'DELETE FROM ' . $this->table . ' WHERE ' . $filters;
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

    $sql = 'UPDATE ' . $this->table . ' SET deleted_at = NOW() WHERE ' . $filters;
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

    $sql = 'UPDATE ' . $this->table . ' 
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
      $this->table . ' WHERE 1 ' .
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

  public function regenerateVkey($vkeyType, $idType, $id)
  {
    $randomVkey = uniqid();

    $this->db->query(
      'UPDATE ' . $this->table . ' 
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

  public function update4($columns, $values, $idTypes, $ids)
  {
    return $this->db->update2($this->table, $columns, $values, $idTypes, $ids);
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
  public function findUserProfile(array $selectedCols = [], array $filterCols = [], array $filterVals = [])
  {
    $selected = join(',', $selectedCols);
    $filters = $this->filters($filterCols, $filterVals);

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' LEFT JOIN profiles on profiles.id = accounts.profile_id WHERE ' . $filters;

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

    $sql = 'SELECT ' . $selected . ' FROM ' . $this->table . ' LEFT JOIN profiles on profiles.id = accounts.profile_id WHERE ' . $filters;
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
      $this->db()->query('SELECT * FROM accounts WHERE id = @@identity');

      return $this->db()->single();
    } else {
      return false;
    }
  }
}
