<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\User;
use App\Role;

class AuthTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();
        $this->registerData = [
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test.user@email.com',
            'password' => 'password'
        ];

    }

    /**
     * @test
     *
     */
    public function userCanCreateAccount()
    {
        $role = factory(Role::class)->create(['name' => 'employer']);

        // Add existing role
        $this->registerData['role'] = $role->name;

        $response = $this->post('/api/v1/auth/register', $this->registerData);

        //Unset password && role coz they aren't returned
        unset($this->registerData['password']);
        unset($this->registerData['role']);

        $response->assertResponseStatus(201);
        $response->seeJson($this->registerData);
    }

    /**
     * @test
     *
     */
    public function userCannotCreateAccountWithNonExistingRole()
    {
        // Add non-existing role
        $this->registerData['role'] = 'non-existing-role';

        $response = $this->post('/api/v1/auth/register', $this->registerData);

        $response->assertResponseStatus(422);
        $response->seeJson(["role" => [
            "The role defined is not available."
        ]]);
    }

    /**
     * @test
     *
     */
    public function userCanLogIn()
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
            'password' => 'password'
        ];

        $response = $this->post('/api/v1/auth/login', $data);

        $response->assertResponseOk();
    }

    /**
     * @test
     *
     */
    public function userCannotLoginWithWrongCredentials()
    {
        $user = factory(User::class)->create();
        $data = [
            'email' => $user->email,
            'password' => 'wrong_password'
        ];

        $response = $this->post('/api/v1/auth/login', $data);

        $response->assertResponseStatus(401);
        $response->seeJson(["message" => "Invalid credentials."]);
    }
}
