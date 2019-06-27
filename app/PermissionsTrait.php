<?php
namespace App;

use App\Role;

trait PermissionsTrait
{

    /**
     * A user can have roles
     *
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Checks if user has any role
     *
     * @params $role
     * @return boolean
     */
    public function hasRole($role)
    {
        if ($this->roles->contains('name', $role)) {
            return true;
        }

        return false;
    }
}
