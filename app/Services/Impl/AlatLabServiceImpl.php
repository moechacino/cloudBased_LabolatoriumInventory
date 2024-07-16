<?php

namespace App\Services\Impl;

use App\Http\Requests\AlatLabCreateRequest;
use App\Http\Resources\AlatLabResource;
use App\Models\Alat_Lab;
use App\Services\AlatLabService;
use App\Traits\ApiResponder;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;


class AlatLabServiceImpl implements AlatLabService
{
    use ApiResponder;

    function create(AlatLabCreateRequest $request): AlatLabResource
    {
        $data = $request->validated();
        $isExist = Alat_Lab::query()->where("rfid_uid", $data["rfid_uid"])->first();
        if ($isExist) {
            $message = "alat lab with rfid uid " . $isExist->rfid_uid . " is exist";
            $this->throwResponse($message, 409, "CONFLICT");
        }
        $alatLab = new Alat_Lab($data);
        $alatLab->save();

        return new AlatLabResource($alatLab);
    }

    function delete(int $id): true
    {
        $alatLab = Alat_Lab::query()->where("id", $id)->first();
        if (!$alatLab) {
            $this->throwResponse("alat lab with id " . $id . " not found", 404, "NOT_FOUND");
        }
        $alatLab->delete();
        return true;
    }

    function edit(AlatLabCreateRequest $request, $id): AlatLabResource
    {
        $data = $request->validated();

        $alatLab = Alat_Lab::query()->where("id", $id)->first();
        if (!$alatLab) {
            $this->throwResponse("alat lab with id " . $id . " not found", 404, "NOT_FOUND");
        }


        if ($data["rfid_uid"] !== $alatLab->rfid_uid) {
            $isExist = Alat_Lab::query()->where("rfid_uid", $data["rfid_uid"])->first();
            if ($isExist) {
                $message = "alat lab with rfid uid " . $isExist->rfid_uid . " is exist";
                $this->throwResponse($message, 409, "CONFLICT");
            }
        }
        $alatLab->rfid_uid = $data["rfid_uid"];
        $alatLab->name = $data["name"];
        $alatLab->isNeedPermission = $data["isNeedPermission"];
        $alatLab->save();

        return new AlatLabResource($alatLab);
    }

    function getOne($id): AlatLabResource
    {
        $alatLab = Alat_Lab::query()->where("id", $id)->first();
        if (!$alatLab) {
            $this->throwResponse("alat lab with id " . $id . " not found", 404, "NOT_FOUND");
        }

        return new AlatLabResource($alatLab);
    }

    function getAll(int $take, string $sort, string $search): array
    {
        $query = Alat_Lab::query();

        if ($sort === "oldest") {
            $query->orderBy('created_at', 'asc');
        } elseif ($sort === "recent") {
            $query->orderBy('created_at', 'desc');
        } elseif ($sort === "recent_update") {
            $query->orderBy('updated_at', "desc");
        }

        if (!empty($search)) {
            $query->where("name", 'LIKE', "%{$search}%");
        }

        $alatLabs = $query->paginate($take);

        return [
            "data" =>AlatLabResource::collection($alatLabs),
            "page" => [
                "current" => $alatLabs->currentPage(),
                "total" => $alatLabs->lastPage(),
                "per_page" => $alatLabs->perPage(),
                "total_items" => $alatLabs->total(),
            ]
        ];
    }

    function getOneByRfid(string $rfid_uid): AlatLabResource
    {
        $alatLab = Alat_Lab::query()->where("rfid_uid", $rfid_uid)->first();
        if (!$alatLab) {
            $this->throwResponse("alat lab with rfid tag " . $rfid_uid . " not found", 404, "NOT_FOUND");
        }

        return new AlatLabResource($alatLab);
    }
}
