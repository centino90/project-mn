<?php

class SessionManager
{
    const SESSION_EXPIRATION = SESSION_EXPIRATION ?? 10 * 60; // 10minutes
    const SESSION_LOGIN_TIMESTAMP = SESSION_LOGIN_TIMESTAMP ?? 'login_timestamp';
    const SESSION_USER = SESSION_USER ?? 'user';
    const SESSION_EMAIL_VERIFIED = SESSION_EMAIL_VERIFIED ?? 'email_verified';
    const SESSION_PASS_REGISTERED = SESSION_PASS_REGISTERED ?? 'password_registered';
    const SESSION_COMPLETE_INFO = SESSION_COMPLETE_INFO ?? 'complete_info';
    const SESSION_CURRENT_REGS_STEP = SESSION_CURRENT_REGS_STEP ?? 'current_registration_step';

    private $url;
    private $userModel = 'User';
    private $user;

    public function __construct()
    {
        require_once '../app/models/' . $this->userModel . '.php';

        $this->url = new UrlManager;
        $this->userModel =  new $this->userModel();

        if (session_status() === PHP_SESSION_NONE) {
            session_start();

            $_SESSION[self::SESSION_LOGIN_TIMESTAMP] = time();
        }
    }

    /**
     * @return SessionManager
     */
    public function start(): object
    {
        if ($this->expired()) {
            $this->clear();
            $this->url->redirectToLoginpage();
            exit();
        }

        $this->set('login_timestamp', time());
        return $this;
    }

    /**
     * @param string $key
     */
    public function get(string $key)
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return null;
    }

    /**
     * @param string $key
     * @return SessionManager
     */
    public function set(string $key, $value): object
    {
        $_SESSION[$key] = $value;
        return $this;
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }

    public function clear(): void
    {
        session_unset();
        session_destroy();
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function expired(): bool
    {
        return $this->has('login_timestamp')
            && $this->idleTime() > self::SESSION_EXPIRATION
            ? true : false;
    }

    private function idleTime(): int
    {
        return time() - $this->get(self::SESSION_LOGIN_TIMESTAMP);
    }

    public function isPasswordRegistered(): bool
    {
        return $this->has(self::SESSION_PASS_REGISTERED)
            && $this->get(self::SESSION_PASS_REGISTERED) === true
            ? true : false;
    }

    public function isEmailVerified(): bool
    {
        return $this->has(self::SESSION_EMAIL_VERIFIED)
            && $this->get(self::SESSION_EMAIL_VERIFIED) === true
            ? true : false;
    }

    public function isCompleteInfo(): bool
    {
        return $this->has(self::SESSION_COMPLETE_INFO)
            && $this->get(self::SESSION_COMPLETE_INFO) === true
            ? true : false;
    }

    public function isLoggedIn(): bool
    {
        return $this->has(self::SESSION_USER)
            && !empty($this->get(self::SESSION_USER)) === true
            ? true : false;
    }

    /**
     * sets and returns the currently sessioned user
     * @param bool $persistUser
     * @return User
     */
    public function auth(bool $persistUser = true): ?object
    {
        if($persistUser && is_object($this->user) && isset($this->user->id)) {
            return $this->user;
        }

        $user = $this->userModel->findUserProfile(
            ['*', 'accounts.id AS id'],
            ['accounts.id'],
            [$this->get(self::SESSION_USER)->id]
        );
        $this->user = $user;

        if (!is_object($user)) {
            return null;
        }

        $this->set(self::SESSION_USER, $user);
        return $user;
    }
}
