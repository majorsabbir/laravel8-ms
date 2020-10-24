<?php

namespace App\Helpers;

trait ACL
{
    public function hasRole($role): bool
    {
        return in_array('administrator', $this->roles()) ?: in_array($role, $this->roles());
    }

    public function hasPermission($permission): bool
    {
        return $this->isAdministrator() ? true : in_array($permission, $this->permissions());
    }

    public function isAdministrator(): bool
    {
        return $this->hasRole('administrator');
    }

    public function roles(): array
    {
        return $this->toArray()['roles'];
    }

    public function permissions(): array
    {
        return $this->toArray()['permissions'];
    }
}
