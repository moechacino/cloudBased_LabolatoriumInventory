<?php

namespace App\Services;

use App\Http\Requests\PeminjamanMahasiswaCreateRequest;
use App\Http\Resources\PeminjamanMahasiswaResource;

interface PeminjamanMahasiswaService
{
    function create(PeminjamanMahasiswaCreateRequest $request): PeminjamanMahasiswaResource;

    function getOne( int $id): PeminjamanMahasiswaResource;

    function getAll(int $take, string $sort = 'recent', string $filter = '', string $status = ''): array;

    function accept(int $id): PeminjamanMahasiswaResource;

    function reject(int $id): PeminjamanMahasiswaResource;

    function pengembalian(int $id) : PeminjamanMahasiswaResource;

    function delete(int $id): bool;
}
