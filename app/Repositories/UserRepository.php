<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create($data)
    {
        return User::create($data);
    }

    public function find($id)
    {
        return User::find($id);
    }
}
