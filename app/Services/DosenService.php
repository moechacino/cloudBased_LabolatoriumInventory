<?php

namespace App\Services;

use App\Http\Requests\DosenCreateRequest;
use App\Http\Resources\DosenResource;

interface DosenService
{
    function create(DosenCreateRequest $request) : DosenResource;

    function getOneByRfid(string $rfid_uid) :DosenResource;

    function getOneById(int $id) :DosenResource;

    function getAll (int $take, string $sort, string $search) : array;

    function delete(int $id) : true;

    function edit(DosenCreateRequest $request, int $id) : DosenResource;
}
