<?php

namespace App\Http\Controllers;

use App\Core\Businesses\Contracts\UserInterface as UserBusiness;
use App\Http\Resources\Collections\UserCollection;

class UserController extends Controller
{
    private $userBusiness;

    public function __construct(UserBusiness $userBusiness)
    {
        $this->userBusiness = $userBusiness;
    }

    public function index()
    {
        return new UserCollection(
            $this->userBusiness->index()
        );
    }
}
