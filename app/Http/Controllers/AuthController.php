<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Repositories\Interfaces\UserInterface;
use App\Repositories\Interfaces\RoleInterface;
use App\Rules\RoleExists;

class AuthController extends Controller
{
    private $userService;
    private $roleService;

    public function __construct(UserInterface $userService, RoleInterface $roleService)
    {
        $this->userService = $userService;
        $this->roleService = $roleService;
    }

    /**
     * Register a user
     *
     * @param Request $request
     * @return response
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'first_name' => 'required|max:55',
            'last_name' => 'required|max:55',
            'email' => 'email|required|unique:users',
            'role' => ['required', new RoleExists()],
            'password' => 'required|min:8'
        ]);
        
        $userRole = $this->roleService->findByName($request->role);

        $user = $this->userService->saveUser($request->all());
        $this->userService->attachUserToRole($user, $userRole);

        return response()->json($user, 201);
    }

    /**
     * Logs in a user
     *
     * @param Request $request
     * @return void
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|email|max:255',
            'password' => 'required',
        ]);

        $user = $this->userService->findByEmail($request->email);
        
        if ($user && $this->userService->validateCredentials($user, $request->password)) {
            return $this->userService->generateToken($request->all());
        } else {
            return response()->json(["status" => "error", "message" => "Invalid credentials."], 401);
        }
    }
}
