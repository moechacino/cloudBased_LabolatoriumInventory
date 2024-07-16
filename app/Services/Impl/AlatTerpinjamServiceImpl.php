<?php

namespace App\Services\Impl;

use App\Http\Resources\AlatTerpinjamResource;
use App\Models\Alat_Terpinjam;
use App\Services\AlatTerpinjamService;
use App\Traits\ApiResponder;
use Carbon\Carbon;

class AlatTerpinjamServiceImpl implements AlatTerpinjamService
{
    use ApiResponder;

    function getAll(int $take, string $sort = 'recent', string $filter = ''): array
    {
        $query = Alat_Terpinjam::query()->with("alat_lab");
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $dateNow = Carbon::now();
        switch ($filter) {
            case 'today_kembali':
                $query->whereDate('tanggal_kembali', $dateNow->toDateString());
                break;
            case 'overdue':
                $query->where('tanggal_kembali', '<', $dateNow->toDateString());
                break;
            default:
                break;
        }

        $alatTerpinjams = $query->paginate($take);

        return [
            "data" => AlatTerpinjamResource::collection($alatTerpinjams),
            "page" => [
                "current" => $alatTerpinjams->currentPage(),
                "total" => $alatTerpinjams->lastPage(),
                "per_page" => $alatTerpinjams->perPage(),
                "total_items" => $alatTerpinjams->total(),
            ]
        ];
    }

    function getOne(int $id): AlatTerpinjamResource
    {
        $alatTerpinjam = Alat_Terpinjam::query()->with("alat_lab")->find($id);
        if(!$alatTerpinjam){
            $this->throwResponse("not found", 404, "NOT_FOUND");
        }
        return new AlatTerpinjamResource($alatTerpinjam);
    }

}
