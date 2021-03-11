<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Store;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements StoreTestContract
{
    use WithModelData;
    use WithUrl;

    /**
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_required_validation_errors(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name field is required.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function strings_validation_errors(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['name' => [Str::random(5)]]);
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
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['name' => Str::random(256)]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name must not be greater than 255 characters.',
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

        $response = $this->passportActingAs($user)->json('post', $this->getRoute(), [
            'name' => $model->name,
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'name' => 'The name has already been taken.',
        ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function integer_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['priority' => [Str::random(8)]]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'priority' => 'The priority must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function integer_min_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['priority' => 0]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'priority' => 'The priority must be at least 1.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_store(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $data = call_user_func($this->model_classname.'::factory')->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200)
            ->assertJson([
                'success'  => true,
                'resource' => [
                    'display_name' => $data['display_name'],
                    'name'         => $data['name'],
                ],
            ]);

        $model = app()->make($this->repository_classname)
            ->findByModelName($data['name']);

        $response->assertJson(['resource' => ['id' => $model->id]]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
