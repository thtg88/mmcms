<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Update;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Feature\Concerns\Update\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\ContentModel\WithModelData;
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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'base_route_name' => [Str::random(5)],
                'model_name' => [Str::random(5)],
                'name' => [Str::random(5)],
                'table_name' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'base_route_name' => 'The base route name must be a string.',
                'model_name' => 'The model name must be a string.',
                'name' => 'The name must be a string.',
                'table_name' => 'The table name must be a string.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function too_long_strings_have_max_validation_errors(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'base_route_name' => Str::random(256),
                'model_name' => Str::random(256),
                'name' => Str::random(256),
                'table_name' => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'base_route_name' => 'The base route name may not be greater than 255 characters.',
                'model_name' => 'The model name may not be greater than 255 characters.',
                'name' => 'The name may not be greater than 255 characters.',
                'table_name' => 'The table name may not be greater than 255 characters.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function unique_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();
        $other_model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'base_route_name' => $other_model->base_route_name,
                'model_name' => $other_model->model_name,
                'name' => $other_model->name,
                'table_name' => $other_model->table_name,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'base_route_name' => 'The base route name has already been taken.',
                'model_name' => 'The model name has already been taken.',
                'name' => 'The name has already been taken.',
                'table_name' => 'The table name has already been taken.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_update(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $data = factory($this->model_classname)->raw();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), $data);
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'resource' => [
                    'id' => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                    'base_route_name' => $data['base_route_name'],
                    'model_name' => $data['model_name'],
                    'name' => $data['name'],
                    'table_name' => $data['table_name'],
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
