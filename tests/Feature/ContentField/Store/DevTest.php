<?php

namespace Thtg88\MmCms\Tests\Feature\ContentField\Store;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\ContentModelRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;
use Thtg88\MmCms\Tests\Feature\Concerns\WithGeneratedFiles;
use Thtg88\MmCms\Tests\Feature\ContentField\WithModelData;
use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements StoreTestContract
{
    use WithModelData;
    use WithUrl;
    use WithGeneratedFiles;

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
                'content_model_id' => 'The content model id field is required.',
                'content_type_id'  => 'The content type id field is required.',
                'display_name'     => 'The display name field is required.',
                'is_resource_name' => 'The is resource name field is required.',
                'is_mandatory'     => 'The is mandatory field is required.',
                'name'             => 'The name field is required.',
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
            ->json('post', $this->getRoute(), [
                'display_name' => [Str::random(5)],
                'helper_text'  => [Str::random(5)],
                'name'         => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'display_name' => 'The display name must be a string.',
                'helper_text'  => 'The helper text must be a string.',
                'name'         => 'The name must be a string.',
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
            ->json('post', $this->getRoute(), [
                'display_name' => Str::random(256),
                'name'         => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'display_name' => 'The display name must not be greater than 255 characters.',
                'name'         => 'The name must not be greater than 255 characters.',
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

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_model_id' => $model->content_model_id,
                'display_name'     => $model->display_name,
                'name'             => $model->name,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'display_name' => 'The display name has already been taken.',
                'name'         => 'The name has already been taken.',
            ]);

        // Check unique case insensitive
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_model_id' => $model->content_model_id,
                'display_name'     => strtoupper($model->display_name),
                'name'             => strtoupper($model->name),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'display_name' => 'The display name has already been taken.',
                'name'         => 'The name has already been taken.',
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
            ->json('post', $this->getRoute(), [
                'content_model_id' => [Str::random(8)],
                'content_type_id'  => [Str::random(8)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_model_id' => 'The content model id must be an integer.',
                'content_type_id'  => 'The content type id must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function content_model_id_exists_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();

        $deleted_content_model = ContentModel::factory()->create();
        app()->make(ContentModelRepository::class)
            ->destroy($deleted_content_model->id);

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_model_id' => rand(1000, 9999),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_model_id' => 'The selected content model id is invalid.',
            ]);

        // Test deleted content model invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_model_id' => $deleted_content_model->id,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_model_id' => 'The selected content model id is invalid.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function content_type_id_exists_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();

        $deleted_content_type = ContentType::factory()->create();
        app()->make(ContentTypeRepository::class)
            ->destroy($deleted_content_type->id);

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_type_id' => rand(1000, 9999),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_type_id' => 'The selected content type id is invalid.',
            ]);

        // Test deleted content type invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_type_id' => $deleted_content_type->id,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_type_id' => 'The selected content type id is invalid.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function boolean_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'is_resource_name' => [Str::random(8)],
                'is_mandatory'     => [Str::random(8)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'is_resource_name' => 'The is resource name field must be true or false.',
                'is_mandatory'     => 'The is mandatory field must be true or false.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_store(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->emailVerified()->dev()->create();
        $data = call_user_func($this->model_classname.'::factory')->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200);

        $model = app()->make($this->repository_classname)
            ->findByModelName($data['name']);

        $response->assertJson([
            'success'  => true,
            'resource' => [
                'id'               => $model->id,
                'created_at'       => $model->created_at->toISOString(),
                'content_model_id' => $data['content_model_id'],
                'content_type_id'  => $data['content_type_id'],
                'display_name'     => $data['display_name'],
                'helper_text'      => $data['helper_text'],
                'is_resource_name' => $data['is_resource_name'],
                'is_mandatory'     => $data['is_mandatory'],
                'name'             => $data['name'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf(ContentModel::class, $model->content_model);
        $this->assertInstanceOf(ContentType::class, $model->content_type);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }

        $this->generated_files = [
            database_path(
                'migrations'.DIRECTORY_SEPARATOR.
                $this->getLatestMigratingMigrationTimestamp().'_add_'.
                $model->name.'_column_to_'.$model->content_model->table_name.
                '_table.php'
            ),
        ];
        $this->assertGeneratedFilesExist();
    }
}
