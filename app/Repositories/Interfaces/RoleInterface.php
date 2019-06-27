<?php

namespace App\Repositories\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface RoleInterface
{
    /**
     * Find a role by name
     *
     * @param string $name
     * @return collection
     */
    public function findByName($name);
}