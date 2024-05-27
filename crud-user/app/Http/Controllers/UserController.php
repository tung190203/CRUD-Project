<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Service\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        $users = $this->userService->getAll();
        return responseSuccess(UserResource::collection($users));
    }

    public function me(): JsonResponse
    {
        $user = auth()->user();
        return responseSuccess(new UserResource($user));
    }

    public function create(CreateRequest $request): JsonResponse
    {
        $user = $this->userService->createUser($request->validated());
        return responseSuccess(new UserResource($user));
    }

    public function update(UpdateRequest $request, $id): JsonResponse
    {
        $user = $this->userService->update($id, $request->validated());
        return responseSuccess(new UserResource($user));
    }

    public function delete($id): JsonResponse
    {
        $this->userService->delete($id);
        return responseSuccess();
    }
}
