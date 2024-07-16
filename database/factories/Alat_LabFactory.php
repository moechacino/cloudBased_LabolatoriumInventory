<?php

namespace Database\Factories;

use App\Models\Alat_Lab;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Alat_LabFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Alat_Lab::class;

    public function definition(): array
    {
        return [
            'rfid_uid' => $this->generateUniqueRfidUid(),
            'name' => $this->faker->colorName,
            'isNeedPermission' => $this->faker->boolean,
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
            $rfid_uid = implode(':', $segments);
        } while (Alat_Lab::query()->where('rfid_uid', $rfid_uid)->exists());

        return $rfid_uid;
    }
}
