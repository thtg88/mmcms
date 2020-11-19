<?php

namespace Thtg88\MmCms\Database\Factories;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail(),
            'name' => $this->faker->name(),
            'password' => Str::random(8),
            'role_id' => config('mmcms.roles.ids.default'),
        ];
    }

    /**
     * Represents a user with its email verified.
     *
     * @return self
     */
    public function emailVerified(): self
    {
        return $this->state([
            'email_verified_at' => now(),
        ]);
    }

    /**
     * Represents an admin user.
     *
     * @return self
     */
    public function admin(): self
    {
        return $this->state([
            'role_id' => config('mmcms.roles.ids.administrator'),
        ]);
    }

    /**
     * Represents a dev user.
     *
     * @return self
     */
    public function dev(): self
    {
        return $this->state([
            'role_id' => config('mmcms.roles.ids.developer'),
        ]);
    }

    /**
     * Represents a user user.
     *
     * @return self
     */
    public function user(): self
    {
        return $this->state([
            'role_id' => config('mmcms.roles.ids.user'),
        ]);
    }
}
