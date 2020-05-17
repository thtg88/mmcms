<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType\Store;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Models\ContentValidationRule;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;
use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\ContentType\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements StoreTestContract
{
    use WithModelData, WithUrl;

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
                'priority' => 'The priority field is required.',
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
                'description' => [Str::random(5)],
                'name' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'description' => 'The description must be a string.',
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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['name' => Str::random(256)]);
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

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'name' => $model->name,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'name' => 'The name has already been taken.',
            ]);

        // Check unique case insensitive
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'name' => strtoupper($model->name),
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
    public function integer_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_migration_method_id' => [Str::random(8)],
                'content_validation_rule_id' => [Str::random(8)],
                'priority' => [Str::random(8)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_migration_method_id' => 'The content migration method id must be an integer.',
                'content_validation_rule_id' => 'The content validation rule id must be an integer.',
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
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();
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
    public function content_migration_method_id_exists_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();

        $deleted_content_migration_method = factory(
            ContentMigrationMethod::class
        )->create();
        app()->make(ContentMigrationMethodRepository::class)
            ->destroy($deleted_content_migration_method->id);

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_migration_method_id' => rand(1000, 9999),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_migration_method_id' => 'The selected content migration method id is invalid.',
            ]);

        // Test deleted content_migration_method invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_migration_method_id' => $deleted_content_migration_method->id,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_migration_method_id' => 'The selected content migration method id is invalid.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function content_validation_rule_id_exists_validation(): void
    {
        $user = factory(User::class)->states('email_verified', 'dev')
            ->create();

        $deleted_content_validation_rule = factory(
            ContentValidationRule::class
        )->create();
        app()->make(ContentValidationRuleRepository::class)
            ->destroy($deleted_content_validation_rule->id);

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_validation_rule_id' => rand(1000, 9999),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_validation_rule_id' => 'The selected content validation rule id is invalid.',
            ]);

        // Test deleted content_validation_rule invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_validation_rule_id' => $deleted_content_validation_rule->id,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_validation_rule_id' => 'The selected content validation rule id is invalid.',
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
                'description' => $data['description'],
                'name' => $data['name'],
                'priority' => $data['priority'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf(
            ContentMigrationMethod::class,
            $model->content_migration_method
        );
        $this->assertInstanceOf(
            ContentValidationRule::class,
            $model->content_validation_rule
        );
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
