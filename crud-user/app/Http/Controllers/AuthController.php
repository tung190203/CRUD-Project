<?php

namespace App\Http\Controllers;

use App\Exceptions\EmailDoesNotExitsException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->userService->register($request->validated());

        return responseCreated(new UserResource($user));
    }

    /**
     * @throws EmailDoesNotExitsException
     * @throws InvalidCredentialsException
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->userService->login($request->validated());

        return responseSuccess($user);
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return responseSuccess('Successfully logged out');
    }
}
