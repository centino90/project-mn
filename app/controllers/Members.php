<?php

class Members extends Controller
{
    public function __construct()
    {
        redirectUnAuthUser();
        redirectNotFullyRegisteredUser();
        redirectInactiveUserOrRegenerateTimer();

        $this->userModel = $this->model('User');
    }

    public function index()
    {
        $data = [
            'current_route' => __FUNCTION__,
        ];
        
        redirect('profiles/userInfo');
    }

}
