<?php

namespace App\Services\Impl;

use App\Http\Requests\PeminjamanMahasiswaCreateRequest;
use App\Http\Resources\PeminjamanMahasiswaResource;
use App\Models\Alat_Lab;
use App\Models\Alat_Terpinjam;
use App\Models\Peminjaman_Mahasiswa;
use App\Services\PeminjamanMahasiswaService;
use App\Traits\ApiResponder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PeminjamanMahasiswaServiceImpl implements PeminjamanMahasiswaService
{
    use ApiResponder;

    function create(PeminjamanMahasiswaCreateRequest $request): PeminjamanMahasiswaResource
    {
        $data = $request->validated();

        $isNotAvailable = Alat_Terpinjam::query()
            ->where('alat_lab_id', $data['alat_lab_id'])
            ->exists();

        if ($isNotAvailable) {
            $this->throwResponse("Alat masih dipinjam dan belum dikembalikan", 409, "CONFLICT");
        }
        $alatLab = Alat_Lab::query()->find($data['alat_lab_id']);

        $peminjaman = new Peminjaman_Mahasiswa($data);
        if($alatLab["isNeedPermission" != true]){
            $peminjaman->accepted = true;
            $peminjaman->sudah_dikembalikan = false;
        }
        $peminjaman->save();

        return new PeminjamanMahasiswaResource($peminjaman);
    }

    function getOne(int $id): PeminjamanMahasiswaResource
    {
        $peminjaman = Peminjaman_Mahasiswa::query()->with(["mahasiswa", "dosen", "alat_lab"])->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        return new PeminjamanMahasiswaResource($peminjaman);
    }

    function getAll(int $take, string $sort = 'recent', string $filter = '', string $status =''): array
    {
        $query = Peminjaman_Mahasiswa::query()->with(["mahasiswa", "dosen", "alat_lab"]);
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
            "data" => PeminjamanMahasiswaResource::collection($peminjamans),
            "page" => [
                "current" => $peminjamans->currentPage(),
                "total" => $peminjamans->lastPage(),
                "per_page" => $peminjamans->perPage(),
                "total_items" => $peminjamans->total(),
            ]
        ];
    }

    function accept(int $id): PeminjamanMahasiswaResource
    {
        $peminjaman = Peminjaman_Mahasiswa::query()->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }

        $isNotAvailable = Alat_Terpinjam::query()->where('alat_lab_id', $peminjaman->alat_lab_id)->exists();

        if ($isNotAvailable) {
            $this->throwResponse("Alat masih dipinjam dan belum dikembalikan", 409, "CONFLICT");
        }

        DB::beginTransaction();
        try {
            $peminjaman->update([
                "accepted"=>true,
                "sudah_dikembalikan"=>false
            ]);

            $alatTerpinjam = new Alat_Terpinjam([
                "alat_lab_id" => $peminjaman->alat_lab_id,
                "tanggal_terpinjam" => $peminjaman->tanggal_peminjaman,
                "tanggal_kembali" => $peminjaman->tanggal_pengembalian,
            ]);
            $alatTerpinjam->save();
            DB::commit();
            return new PeminjamanMahasiswaResource($peminjaman);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->throwResponse("Transaksi gagal", 500, "INTERNAL_SERVER_ERROR", [
                "details" => $e->getMessage()
            ]);
        }
    }

    function reject(int $id): PeminjamanMahasiswaResource
    {
        $peminjaman = Peminjaman_Mahasiswa::query()->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        $peminjaman->update([
            "accepted" => false
        ]);
        return new PeminjamanMahasiswaResource($peminjaman);
    }

    function pengembalian(int $id): PeminjamanMahasiswaResource
    {
        $peminjaman = Peminjaman_Mahasiswa::query()->find($id);
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
        return new PeminjamanMahasiswaResource($peminjaman);
        } catch (\Exception $e){
            DB::rollBack();
            $this->throwResponse("Transaksi gagal", 500, "INTERNAL_SERVER_ERROR", [
                "details" => $e->getMessage()
            ]);
        }
    }

    function delete(int $id): bool
    {
        $peminjaman = Peminjaman_Mahasiswa::query()->find($id);
        if (!$peminjaman) {
            $this->throwResponse("Peminjaman tidak ditemukan", 404, "NOT_FOUND");
        }
        $peminjaman->delete();
        return true;
    }
}
