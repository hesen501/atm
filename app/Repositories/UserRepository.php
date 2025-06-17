<?php
namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function all()
    {
        return User::query()->get();
    }

    public function find($id)
    {
        return User::query()->findOrFail($id);
    }

    public function create($data)
    {
        return User::query()->create($data);
    }

    public function update($id, $data)
    {
        $user = User::query()->findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        $user = User::query()->findOrFail($id);
        return $user->delete();
    }
}
