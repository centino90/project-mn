<?php
/*
   * Base Controller
   * Loads the models and views
   */
class Controller
{
  public $session;
  public $url;
  public $role;

  public function __construct()
  {
    $this->session = new SessionManager;
    $this->url = new UrlManager;
    $this->role = new Roles;
  }

  // Load model
  public function model($model)
  {
    // Require model file
    require_once '../app/models/' . $model . '.php';

    // Instatiate model
    return new $model();
  }

  // Load view
  public function view($view, $data = [])
  {
    // Check for view file
    if (file_exists('../app/views/' . $view . '.php')) {
      require_once '../app/views/' . $view . '.php';
    } else {
      $this->view('users/redirectPage', array('message' => 'View \'' . $view . '\' does not exist'));
      exit();
    }
  }

  public function isLoggedin()
  {
    return $this->session->has('user') === true
      && is_object($this->session->get('user'))
      ? true : false;
  }

  public function isEmailVerified()
  {
    return $this->session->has('email_verified') === true
      && $this->session->get('email_verified') === true
      ? true : false;
  }

  public function isCompleteInfo()
  {
    return $this->session->has('complete_info')
      && $this->session->get('complete_info') === true
      ? true : false;
  }

  public function isPasswordRegistered()
  {
    return $this->session->has('password_registered')
      && $this->session->get('password_registered') === true
      ? true : false;
  }

}
