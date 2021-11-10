<?php
  class User {
    private $db;

    public function __construct(){
      $this->db = new Database;
    }

    // Regsiter user
    public function register($data){
      $this->db->query('INSERT INTO users (first_name, last_name, email, password, fb_user_id, fb_access_token, google_user_id, google_access_token) VALUES(:first_name, :last_name, :email, :password, :fb_user_id, :fb_access_token, :google_user_id, :google_access_token)');
      // Bind values
      // $this->db->bind(':name', $data['name']);
      $this->db->bind(':first_name', $data['first_name']);
      $this->db->bind(':last_name', $data['last_name']);
      $this->db->bind(':email', $data['email']);
      $this->db->bind(':password', $data['password'] ?? '');
      $this->db->bind(':fb_user_id', $data['id'] ?? '');
      $this->db->bind(':fb_access_token', $data['fb_access_token'] ?? '');
      $this->db->bind(':google_user_id', $data['google_user_id'] ?? '');
      $this->db->bind(':google_access_token', $data['google_access_token'] ?? '');

      // Execute
      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }

    // Login User
    public function login($email, $password){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      $hashed_password = $row->password;
      if(password_verify($password, $hashed_password)){
        return $row;
      } else {
        return false;
      }
    }

    // Find user by email
    public function findUserByEmail($email){
      $this->db->query('SELECT * FROM users WHERE email = :email');
      // Bind value
      $this->db->bind(':email', $email);

      $row = $this->db->single();

      // Check row
      if($this->db->rowCount() > 0){
        return true;
      } else {
        return false;
      }
    }

    // Get User by ID
    public function getUserById($id){
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

    function updateRowById( $table, $column, $value, $id ) {
      $sql = 'UPDATE ' . $table . ' SET ' . $column . ' = :' . $column . ' WHERE id = :id';
      $this->db->query($sql);

      $this->db->bind(':' . $column, $value);
      $this->db->bind(':id', $id);

      if($this->db->execute()){
        return true;
      } else {
        return false;
      }
    }
  }