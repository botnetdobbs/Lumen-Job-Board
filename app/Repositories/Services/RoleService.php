<?php

namespace App\Repositories\Services;

use App\Repositories\Interfaces\RoleInterface;
use App\Role;

class RoleService implements RoleInterface
{
    /**
     * Find a role by name
     *
     * @param string $name
     * @return collection
     */
    public function findByName($name)
    {
        return Role::where('name', strtolower($name))->first();
    }
}
