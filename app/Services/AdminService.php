<?php

namespace App\Services;

use App\Http\Requests\AdminLoginRequest;
use App\Http\Resources\AdminResource;

interface AdminService
{
    function login(AdminLoginRequest $request) : AdminResource;
    function  logout(string $id) : bool;
}
