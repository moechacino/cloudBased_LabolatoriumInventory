<?php

namespace App\Services;

use App\Http\Requests\MahasiswaCreateRequest;
use App\Http\Resources\MahasiswaResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface MahasiswaService
{
    function create(MahasiswaCreateRequest $request) : MahasiswaResource;

    function getOneByRfid(string $rfid_uid) :MahasiswaResource;

    function getOneById(int $id) :MahasiswaResource;

    function getAll (int $take, string $sort, string $search) : array;

    function delete(int $id) : true;

    function edit(MahasiswaCreateRequest $request, int $id) : MahasiswaResource;
}
