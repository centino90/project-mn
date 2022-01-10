<?php

class UrlManager
{
    const CURRENT_ROUTE = __FUNCTION__;
    
    private $home = 'profiles/userinfo';
    private $login = 'users/login';

    public function __construct()
    {
    }

    public function redirect(string $page): void
    {
        header('location: ' . URLROOT . '/' . $page);
    }

    public function redirectBack(): void
    {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    public function redirectToHomepage(): void
    {
        header('location: ' . URLROOT . '/' . $this->home);
    }

    public function redirectToLoginpage(): void
    {
        header('location: ' . URLROOT . '/' . $this->login);
    }
}
