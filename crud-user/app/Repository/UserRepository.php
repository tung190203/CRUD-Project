<?php

namespace App\Repository;

use App\Models\User;

class UserRepository extends BaseRepository
{
    public function getModel(): string
    {
        return User::class;
    }

    public function findByEmail(string $email)
    {
        return $this->model->where('email', $email)->first();
    }

    public function getAllUsers()
    {
        return $this->model->where('role', 'user')->get();
    }

    public function find($id)
    {
        return $this->model->findOrFail($id);
    }
}
