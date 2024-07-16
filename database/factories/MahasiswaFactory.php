<?php

namespace Database\Factories;

use App\Models\Mahasiswa;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Mahasiswa::class;
    public function definition(): array
    {
        return [
            'rfid_uid' => $this->generateUniqueRfidUid(),
            'name' => $this->faker->name,
            'nrp' => $this->faker->numerify("#######"),
        ];
    }

    private function generateUniqueRfidUid(): string
    {
        do {
            $segments = [];
            for ($i = 0; $i < 5; $i++) {
                $segment = $this->faker->regexify('[A-Z0-9]{2}');
                $segments[] = $segment;
            }
            $uid = implode(':', $segments);
        } while (Mahasiswa::query()->where('rfid_uid', $uid)->exists());

        return $uid;
    }
}
