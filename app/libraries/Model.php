<?php
/*
   * Base Model
   * Contains all the shared attributes / behaviours
   */
class Model
{
  public $db;
  public $table;
  public $primaryKey;

  public function __construct()
  {
    $this->db = new Database;
  }

  protected function db()
  {
    return $this->db;
  }

  protected function column($column)
  {
    return empty($column) || !$column
      ? null : trim($column);
  }

  protected function filters($filterCols, $filterVals)
  {
    if (sizeof($filterCols) !== sizeof($filterVals)) {
      throw new Error('Error: columns and values must have the same length');
    }

    $i = 0;
    $filters = '';
    if (!empty($filterCols) && !empty($filterVals)) {
      foreach ($filterCols as $column) {
        if (++$i === count($filterCols)) {
          $filters .= $column . ' = :' . $this->placeholder($column);
          break;
        }
        $filters .= $column . ' = :' . $this->placeholder($column) . ' AND ';
      }
    }

    return $filters;
  }

  protected function placeholder($column)
  {
    return str_replace('.', '_', $column);
  }

}
