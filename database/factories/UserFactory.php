<?php

namespace Database\Factories;

use App\Enum\User\RoleEnum;
use App\Pipelines\QueryFilter\Civilian\BetweenAge;
use App\Pipelines\QueryFilter\Helper\CivilianPipeline;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'civilian_id' => $this->faker->unique()->randomElement(
                CivilianPipeline::thenReturnStatic([
                    BetweenAge::class . ':' . 40 . ',' . 20
                ])
                ->pluck('id')
                ->toArray()
            ),
            'username' => $this->faker->unique()->userName(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make(env('DEFAULT_USER_PASSWORD')),
            'role' => $this->faker->randomElement(RoleEnum::getValuesWithout(RoleEnum::CHAIRMAN->value)),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
