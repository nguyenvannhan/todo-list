<?php

namespace App\Core\Businesses;

use App\Core\Businesses\Contracts\ApiResourceInterface;
use App\Core\Businesses\Contracts\UserInterface;
use App\Core\Repositories\Contracts\UserInterface as UserRepository;

class UserBusiness implements UserInterface, ApiResourceInterface
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return $this->userRepository->getList(['id', 'name']);
    }

    public function store($data)
    {
        return null;
    }

    public function update($id, $data)
    {
        return null;
    }

    public function show($id)
    {
        return null;
    }

    public function destroy($id)
    {
        return null;
    }
}
