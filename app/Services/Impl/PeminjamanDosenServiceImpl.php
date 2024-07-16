<?php

namespace App\Services\Impl;

use App\Http\Requests\PeminjamanDosenCreateRequest;
use App\Http\Resources\PeminjamanDosenResource;
use App\Models\Alat_Terpinjam;
use App\Models\Dosen;
use App\Models\Peminjaman_Dosen;
use App\Services\PeminjamanDosenService;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanDosenServiceImpl implements PeminjamanDosenService
{
    use ApiResponder;

    function create(PeminjamanDosenCreateRequest $request): PeminjamanDosenResource
    {
        $data = $request->validated();

        $isDosenExist = Dosen::query()->find($data["dosen_id"]);
        if (!$isDosenExist) {
            $this->errorResponse("Dosen tidak ditemukan", 404, "NOT_FOUND");
        }

        $isNotAvailable = Alat_Terpinjam::query()
            ->where('alat_lab_id', $data['alat_lab_id'])
            ->exists();

        if ($isNotAvailable) {
            $this->throwResponse("Alat masih dipinjam dan belum dikembalikan", 409, "CONFLICT");
        }

        $peminjaman = new Peminjaman_Dosen($data);

        $peminjaman->accepted = true;
        $peminjaman->sudah_dikembalikan = false;

        $peminjaman->save();

        return new PeminjamanDosenResource($peminjaman);
    }

    function getOne(int $id): PeminjamanDosenResource
    {
        $peminjaman = Peminjaman_Dosen::query()->with(["dosen", "alat_lab"])->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        return new PeminjamanDosenResource($peminjaman);
    }

    function getAll(int $take, string $sort = 'recent', string $filter = '', string $status = ''): array
    {
        $query = Peminjaman_Dosen::query()->with([ "dosen", "alat_lab"]);
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'recent_update':
                $query->orderBy('updated_at', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }
        $dateNow = Carbon::now();
        switch ($filter) {
            case 'today_peminjaman':
                $query->whereDate('tanggal_peminjaman', $dateNow->toDateString());
                break;
            case 'today_pengembalian':
                $query->whereDate('tanggal_pengembalian', $dateNow->toDateString());
                break;
            case 'overdue':
                $query->where('tanggal_pengembalian', '<', $dateNow->toDateString());
                break;
            default:
                break;
        }
        switch ($status){
            case 'accepted':
                $query->where("accepted", true);
                break;
            case 'rejected':
                $query->where("accepted", false);
                break;
            case 'queue':
                $query->where("accepted", null);
                break;
            default:
                break;
        }

        $peminjamans = $query->paginate($take);

        return [
            "data" => PeminjamanDosenResource::collection($peminjamans),
            "page" => [
                "current" => $peminjamans->currentPage(),
                "total" => $peminjamans->lastPage(),
                "per_page" => $peminjamans->perPage(),
                "total_items" => $peminjamans->total(),
            ]
        ];
    }


    function pengembalian(int $id): PeminjamanDosenResource
    {
        $peminjaman = Peminjaman_Dosen::query()->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        if($peminjaman["accepted"] != true){
            $this->throwResponse("Peminjaman belum disetujui", 400, "BAD_REQUEST");
        }

        DB::beginTransaction();
        try {
            $peminjaman->update([
                "sudah_dikembalikan"=>true
            ]);
            $alatTerpinjam = Alat_Terpinjam::query()->where("alat_lab_id", $peminjaman["alat_lab_id"])->first();
            if($alatTerpinjam){
                $alatTerpinjam->delete();
            }
            DB::commit();
            return new PeminjamanDosenResource($peminjaman);
        } catch (\Exception $e){
            DB::rollBack();
            $this->throwResponse("Transaksi gagal", 500, "INTERNAL_SERVER_ERROR", [
                "details" => $e->getMessage()
            ]);
        }
    }

    function delete(int $id): bool
    {
        $peminjaman = Peminjaman_Dosen::query()->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        $peminjaman->delete();
        return true;
    }
}
