<?php

namespace Database\Seeders;

use App\Http\Resources\PeminjamanMahasiswaResource;
use App\Models\Alat_Terpinjam;
use App\Models\Peminjaman_Mahasiswa;
use App\Traits\ApiResponder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PeminjamanMahasiswaSeeder extends Seeder
{
    use ApiResponder;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 7; $i++) {
        $peminjaman = Peminjaman_Mahasiswa::factory()->create();
        if($peminjaman["accepted"] == true){
            DB::beginTransaction();
            try {
                $alatTerpinjam = new Alat_Terpinjam([
                    "alat_lab_id" => $peminjaman->alat_lab_id,
                    "tanggal_terpinjam" => $peminjaman->tanggal_peminjaman,
                    "tanggal_kembali" => $peminjaman->tanggal_pengembalian,
                ]);
                $alatTerpinjam->save();
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->throwResponse("Transaksi gagal", 500, "INTERNAL_SERVER_ERROR", [
                    "details" => $e->getMessage()
                ]);
            }
        }
        }
    }
}
