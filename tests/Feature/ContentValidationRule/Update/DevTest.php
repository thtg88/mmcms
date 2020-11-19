<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule\Update;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Feature\Concerns\Update\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\ContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements UpdateTestContract
{
    use WithModelData, WithUrl, ActingAsDevTest;

    /**
     * @return void
     * @group crud
     * @test
     */
    public function strings_validation_errors(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'name' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name must be a string.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function too_long_strings_have_max_validation_errors(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'name' => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name may not be greater than 255 characters.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function unique_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();
        $other_model = call_user_func($this->model_classname.'::factory')->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'name' => $other_model->name,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name has already been taken.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_update(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();

        $data = call_user_func($this->model_classname.'::factory')->raw();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), $data);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'resource' => [
                    'id' => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                    'name' => $data['name'],
                ],
            ]);

        $model = $model->refresh();

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
