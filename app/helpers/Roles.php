<?php

class Roles
{
    const ROLE_SUPERADMIN = 'superadmin';
    const ROLE_ADMIN = 'admin';
    const ROLE_MEMBER = 'member';

    public function __construct()
    {
        $this->session = new SessionManager;
    }

    public function isSuperAdmin(?string $role = null): bool
    {
        if (empty($role) && $this->session->has('user') && !empty($this->session->get('user')->role)) {
            return $this->session->get('user')->role === self::ROLE_SUPERADMIN;
        }

        return $role === self::ROLE_SUPERADMIN;
    }

    public function isAdmin(?string $role = null): bool
    {
        if (empty($role) && $this->session->has('user') && !empty($this->session->get('user')->role)) {
            return $this->session->get('user')->role === self::ROLE_ADMIN;
        }

        return $role === self::ROLE_ADMIN;
    }


    public function isMember(?string $role = null): bool
    {
        if (empty($role) && $this->session->has('user') && !empty($this->session->get('user')->role)) {
            return $this->session->get('user')->role === self::ROLE_MEMBER;
        }

        return $role === self::ROLE_MEMBER;
    }
}
