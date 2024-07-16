<?php

namespace App\Services;

use App\Http\Resources\AlatTerpinjamResource;

interface AlatTerpinjamService
{
    function getAll(int $take, string $sort = 'recent', string $filter = ''): array;

    function getOne(int $id): AlatTerpinjamResource;

}
