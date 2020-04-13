<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory\Update;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Concerns\Update\ActingAsDevTest;
use Thtg88\MmCms\Tests\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\ImageCategory\WithModelData;
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
                'name' => [Str::random(5)],
                'target_table' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name must be a string.',
                'target_table' => 'The target table must be a string.',
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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();
        $other_model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'name' => $other_model->name,
                'target_table' => $other_model->target_table,
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
    public function valid_target_table_errors(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'target_table' => Str::random(10),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'target_table' => 'The selected target table is invalid.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function integer_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), [
                'sequence' => [Str::random(8)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'sequence' => 'The sequence must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function integer_min_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->passportActingAs($user)
            ->json('put', $this->getRoute([$model->id]), ['sequence' => 0]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'sequence' => 'The sequence must be at least 1.',
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
                    'name' => $data['name'],
                    'sequence' => $data['sequence'],
                    'target_table' => $data['target_table'],
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
