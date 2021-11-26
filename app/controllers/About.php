<?php
class About extends Controller
{
  public function __construct()
  {

    $this->userModel = $this->model('User');
  }

  public function index()
  {
    $data = [
      'current_route' => __FUNCTION__
    ];

    $this->view('about/index', $data);
  }
  public function termsOfService()
  {
    $data = [
      'current_route' => __FUNCTION__
    ];

    $this->view('about/terms', $data);
  }
  public function privacyPolicy()
  {
    $data = [
      'current_route' => __FUNCTION__

    ];

    $this->view('about/privacy', $data);
  }
}
