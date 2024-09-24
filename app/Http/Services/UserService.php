<?php

namespace App\Http\Services;

use App\Models\User;
use Exception;

class UserService
{
    /**
     * Attempt to create user
     *
     * @throws Exception
     */
    public function createUser($data)
    {
        try {
            return User::create($data);
        } catch (\Exception $e) {
            throw new Exception('Failed to create user.');
        }
    }
}
