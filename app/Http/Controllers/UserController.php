<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;

/**
 * @property \App\Services\UserService $userService
 */
class UserController extends Controller
{
    /**
     * @var \App\Services\UserService
     */
    private $userService;

    /**
     * UserController constructor.
     *
     * @param  \App\Services\UserService  $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Register a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        // Validate request data
        try {
            $validatedData = $request->validate([
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'password' => 'required|min:6',
            ]);
            
            // Register user
            $user = $this->userService->register($validatedData);
            if (!$user) {
                return response()->json(['message' => 'Failed to register user'], 500);
            }
            
            // Return a response indicating successful registration
            return response()->json(['message' => 'User registered successfully'], 201);
        } catch (ValidationException  $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    /**
     * Log in a user and generate JWT token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        // Validate request data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt login and generate JWT token
        try {
            $token = $this->userService->login($request->only(['email', 'password']));
            
            if (!$token) {
                return response()->json(['message' => 'Invalid credentials'], 401);
            }

            return response()->json(['token' => $token], 200);
        } catch (JWTException $e) {
            // Handle JWT exception
            return response()->json(['message' => 'Failed to generate token'], 500);
        }
    }
}