<?php

namespace Database\Factories;

use App\Models\Alat_Lab;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Peminjaman_Mahasiswa;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Peminjaman_Mahasiswa>
 */
class Peminjaman_MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Peminjaman_Mahasiswa::class;
    public function definition(): array
    {
        $tanggal_peminjaman = Carbon::now()->format('Y-m-d');
        $tanggal_pengembalian = Carbon::now()->addDays(3)->format('Y-m-d');
        $alatLab = Alat_Lab::factory()->create();

        $data = [
            "alat_lab_id" =>$alatLab->id,
            "dosen_id" => Dosen::factory()->create()->id,
            "mahasiswa_id" => Mahasiswa::factory()->create()->id,
            "phone" => $this->faker->phoneNumber(),
            "keperluan"=> $this->faker->text(50),
            "tempat_pemakaian"=> $this->faker->text(50),
            "tanggal_peminjaman"=> $tanggal_peminjaman,
            "tanggal_pengembalian"=> $tanggal_pengembalian,
        ];
        if($alatLab->isNeedPermission != true){
            $data["accepted"] = true;
            $data["sudah_dikembalikan"] = false;
        }
        return $data;
    }
}
