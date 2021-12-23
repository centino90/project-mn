<?php
  /*
   * Base Controller
   * Loads the models and views
   */
  class Controller {
    protected $ROLE_SUPERADMIN = 'superadmin';
    protected $ROLE_ADMIN = 'admin';
    protected $ROLE_MEMBER = 'member';

    protected function isSuperAdmin($role)
    {
      return $role === $this->ROLE_SUPERADMIN;
    }

    protected function isAdmin($role)
    {
      return $role === $this->ROLE_ADMIN;
    }


    protected function isMember($role)
    {
      return $role === $this->ROLE_MEMBER;
    }


    // Load model
    public function model($model){
      // Require model file
      require_once '../app/models/' . $model . '.php';

      // Instatiate model
      return new $model();
    }

    // Load view
    public function view($view, $data = []){
      // Check for view file
      if(file_exists('../app/views/' . $view . '.php')){
        require_once '../app/views/' . $view . '.php';
      } else {
        // View does not exist
        die('View does not exist');
      }
    }
  }