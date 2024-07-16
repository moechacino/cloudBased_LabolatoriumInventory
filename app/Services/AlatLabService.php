<?php

namespace App\Services;

use App\Http\Requests\AlatLabCreateRequest;
use App\Http\Resources\AlatLabResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

interface AlatLabService
{
    function create(AlatLabCreateRequest $request) : AlatLabResource;
    function delete(  int $id): true;
    function edit(AlatLabCreateRequest $request, $id): AlatLabResource;

    function getOne($id) : AlatLabResource;

    function getOneByRfid(string $rfid_uid) : AlatLabResource;
    function getAll(int $take, string $sort, string $search) : array;
}
