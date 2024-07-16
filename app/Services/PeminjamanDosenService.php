<?php

namespace App\Services;

use App\Http\Requests\PeminjamanDosenCreateRequest;
use App\Http\Resources\PeminjamanDosenResource;

interface PeminjamanDosenService
{
    function create(PeminjamanDosenCreateRequest $request): PeminjamanDosenResource;

    function getOne( int $id): PeminjamanDosenResource;

    function getAll(int $take, string $sort = 'recent', string $filter = '', string $status = ''): array;


    function pengembalian(int $id) : PeminjamanDosenResource;

    function delete(int $id): bool;
}
