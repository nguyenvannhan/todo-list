<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\UserInterface;

class UserRepository extends BaseHelper implements UserInterface
{
    public function getModel()
    {
        return \App\Models\User::class;
    }
}
