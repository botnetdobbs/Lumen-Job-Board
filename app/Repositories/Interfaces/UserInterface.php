<?php

namespace App\Repositories\Interfaces;

/**
 * @codeCoverageIgnore
 */
interface UserInterface
{
    /**
     * Get a specific user
     *
     * @param string $email
     * @return collection
     */
    public function findByEmail($email);

    /**
     * Add user
     *
     * @param array $user
     * 
     * @return collection
     */
    public function saveUser($user);

    /**
     * Attach a user to a role
     *
     * @param collection $user
     * @param collection $role
     */
    public function attachUserToRole($user, $role);

    /**
     * Validate if credentials belong to an actual user
     *
     * @param collection $user
     * @param string $password
     * @return boolean
     */
    public function validateCredentials($user, $password);

    /**
     * Generates and returns token
     *
     * @param array $request
     * @return response
     */
    public function generateToken($request);
}