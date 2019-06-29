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

    public function jobs()
    {
        return $this->hasMany(Job::class, 'employer_id');
    }

    public function addJob($job)
    {
        return $this->jobs()->create($job);
    }
}
