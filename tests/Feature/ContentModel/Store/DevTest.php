<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel\Store;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\Feature\ContentModel\WithModelData;
use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements StoreTestContract
{
    use WithModelData, WithUrl;

    /**
     * The files expected to have been created in the successful tests.
     *
     * @var array
     */
    protected $expected_files = [];

    /**
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_required_validation_errors(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
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
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
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

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'base_route_name' => $model->base_route_name,
                'model_name' => $model->model_name,
                'name' => $model->name,
                'table_name' => $model->table_name,
            ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
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
    public function successful_store(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $data = factory($this->model_classname)->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200);

        $model = app()->make($this->repository_classname)
            ->findByModelName($data['name']);

        $response->assertJson([
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

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }

        // check new table exists
        $this->assertTrue(Schema::hasTable($data['table_name']));

        $this->expected_files = [
            database_path(
                'migrations'.DIRECTORY_SEPARATOR.now()->format('Y_m_d_His').
                '_create_'.$data['table_name'].'_table.php'
            ),
            app_path($data['model_name'].'.php'),
            app_path(
                'Repositories'.DIRECTORY_SEPARATOR.$data['model_name'].
                'Repository.php'
            ),
            app_path(
                'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR.
                $data['model_name'].DIRECTORY_SEPARATOR.'DestroyRequest.php'
            ),
            app_path(
                'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR.
                $data['model_name'].DIRECTORY_SEPARATOR.'StoreRequest.php'
            ),
            app_path(
                'Http'.DIRECTORY_SEPARATOR.'Requests'.DIRECTORY_SEPARATOR.
                $data['model_name'].DIRECTORY_SEPARATOR.'UpdateRequest.php'
            ),
            app_path(
                'Http'.DIRECTORY_SEPARATOR.'Controllers'.
                DIRECTORY_SEPARATOR.$data['model_name'].'Controller.php'
            ),
        ];

        // check new files have been created
        foreach ($this->expected_files as $_file) {
            $this->assertTrue(file_exists($_file));
        }
    }

    protected function tearDown(): void
    {
        // Remove created files
        if (count($this->expected_files) > 0) {
            app()->make(Filesystem::class)->delete($this->expected_files);
        }

        parent::tearDown();
    }
}
