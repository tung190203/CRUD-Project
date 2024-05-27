<?php

namespace App\Service;

use App\Exceptions\EmailDoesNotExitsException;
use App\Exceptions\InvalidCredentialsException;
use App\Http\Resources\UserResource;
use App\Repository\UserRepository;
use Illuminate\Support\Str;

class UserService
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(array $data)
    {
        return $this->userRepository->create($data);
    }

    /**
     * @throws EmailDoesNotExitsException
     * @throws InvalidCredentialsException
     */
    public function login(array $data): array
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if (!$user) {
            throw new EmailDoesNotExitsException(__('validation.email_does_not_exists'));
        }
        if (!$token = auth()->attempt($data)) {
            throw new InvalidCredentialsException(__('validation.invalid_credentials'));
        }

        return $this->responseWithToken($token, $user);
    }

    private function responseWithToken(string $token, object $user): array
    {
        return [
            'token' => [
                'access_token' => $token,
                'token_type' => 'Bearer',
                'expires_in' => 3600,
            ],
            'user' => new UserResource($user),
        ];
    }

    public function getAll()
    {
        return $this->userRepository->getAllUsers();
    }

    public function delete($id)
    {
        return $this->userRepository->delete($id);
    }

    public function update($id, array $data)
    {
        $user = $this->userRepository->find($id);
        $user->update($data);

        return $user;
    }

    public function createUser(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if (!$user) {
            $user = $this->userRepository->create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Str::random(10),
            ]);
        }

        return $user;
    }
}
