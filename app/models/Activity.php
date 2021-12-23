<?php
class Activity
{
  private $db;
  private $table = 'activities';

  public function __construct()
  {
    $this->db = new Database;
  }

  // insert activity
  public function store($data)
  {
    $this->db->query(
      'INSERT INTO ' . $this->table . '
          (
            user_id, initiator, type, message
          ) 
        VALUES
          (
            :user_id, :initiator, :type, :message
          )
        '
    );

    $this->db->bind(':user_id', $data['user_id']);
    $this->db->bind(':initiator', $data['initiator']);
    $this->db->bind(':message', $data['message']);
    $this->db->bind(':type', $data['type']);

    if ($this->db->execute()) {
      return true;
    } else {
      return false;
    }
  }

  public function getAll()
  {
    return $this->db->selectAllWithSingleJoin(
      $this->table,
      'users',
      'user_id',
      'users.id',
      [
        $this->table . '.*'
      ]
    );
  }
  public function get()
  {
  }
  public function selectAll($columns, $filters, $orderColumn, $orderType, $limitRow, $limitPerpage)
  {
    return $this->db->dataTable(
      $this->table,
      $columns,
      $filters,
      $orderColumn,
      $orderType,
      $limitRow,
      $limitPerpage
    );
  }
  public function count(string $filters = '')
  {
    if (!empty($filters)) {
      return $this->db->countAllWithFilters($this->table, $filters)
        ->count;
    } else {
      return $this->db->countAll($this->table)
        ->count;
    }
  }
}
