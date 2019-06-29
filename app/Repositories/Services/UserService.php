<?php

namespace App\Repositories\Services;

use Illuminate\Http\Request;
use App\Repositories\Interfaces\UserInterface;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserService implements UserInterface
{
    public function __construct()
    {
        $this->appUrl = env('APP_URL');
    }

    /**
     * Get a specific user
     *
     * @param string $email
     * @return collection
     */
    public function findByEmail($email)
    {
        return User::where('email', $email)->first();
    }

    /**
     * Add user
     *
     * @param array $user
     *
     * @return collection
     */
    public function saveUser($user)
    {
        $user['password'] = Hash::make($user['password']);
        return User::create($user);
    }

    /**
     * Attach a user to a role
     *
     * @param collection $user
     * @param collection $role
     */
    public function attachUserToRole($user, $role)
    {
        DB::insert('insert into users_roles (user_id, role_id) values (?, ?)', [$user->id, $role->id]);
    }

    /**
     * Validate if credentials belong to an actual user
     *
     * @param collection $user
     * @param string $password
     * @return boolean
     */
    public function validateCredentials($user, $password)
    {
        if (Hash::check($password, $user->password)) {
            return true;
        }
        return false;
    }

    /**
     * Generates and returns token
     *
     * @param array $request
     * @return response
     */
    public function generateToken($request)
    {
        $data = [
            "grant_type"=> "password",
            "client_id"=> "2",
            "client_secret"=> env('CLIENT_SECRET'),
            "username"=> $request['email'],
            "password"=> $request['password'],
            "scope"=> "*"
        ];

        $request = Request::create(
            'oauth/token',
            'POST',
            $data
        );

        $response = app()->handle($request);
        $response = (array) json_decode($response->getContent(), true);
        unset($response['refresh_token']);
        unset($response['expires_in']);

        return $response;
    }
}
