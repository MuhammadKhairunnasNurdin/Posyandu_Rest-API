<?php

namespace Database\Factories;

use App\Enum\MedialCheckup\GroupEnum;
use App\Enum\MedialCheckup\StatusEnum;
use App\Enum\User\RoleEnum;
use App\Pipelines\QueryFilter\Civilian\ByAge;
use App\Pipelines\QueryFilter\Helper\CivilianPipeline;
use App\Pipelines\QueryFilter\Helper\UserPipeline;
use App\Pipelines\QueryFilter\User\ByRole;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCheckup>
 */
class MedicalCheckupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->randomElement(
                UserPipeline::thenReturnStatic([
                    ByRole::class . ':' . RoleEnum::MEMBER->value,
                ])
                ->pluck('id')
                ->toArray()),
            'checkup_date' => $this->faker->dateTimeBetween('-1 years')->format('Y-m-d'),
            'weight' => $this->faker->randomFloat(6, 30.999, 200.999),
            'height' => $this->faker->randomFloat(6, 0.666, 2.999),
            'status' => $this->faker->randomElement(StatusEnum::getValues())
        ];
    }

    /**
     * additional different state value attributes for group elderly
     * @return \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCheckup>
     */
    public function elderly(): Factory
    {
        return $this->state(function () {
            return [
                'civilian_id' => $this->faker->randomElement(
                    CivilianPipeline::thenReturnStatic([
                        ByAge::class . ':<=,50',
                    ])
                    ->pluck('id')
                    ->toArray()
                ),
                'group' => GroupEnum::ELDERLY->value,
            ];
        });
    }

    /**
     * additional different state value attributes for group baby
     * @return \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MedicalCheckup>
     */
    public function baby(): Factory
    {
        return $this->state(function () {
            return [
                'civilian_id' => $this->faker->randomElement(
                    CivilianPipeline::thenReturnStatic([
                        ByAge::class . ':>=,5',
                    ])
                    ->pluck('id')
                    ->toArray()
                ),
                'group' => GroupEnum::BABY->value,
            ];
        });
    }
}
