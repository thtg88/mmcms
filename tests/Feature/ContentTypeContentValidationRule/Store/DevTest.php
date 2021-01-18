<?php

namespace Thtg88\MmCms\Tests\Feature\ContentTypeContentValidationRule\Store;

use Illuminate\Support\Str;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Models\ContentValidationRule;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\Feature\ContentTypeContentValidationRule\WithModelData;
use Thtg88\MmCms\Tests\Feature\Contracts\StoreTest as StoreTestContract;
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
                'content_type_id'            => 'The content type id field is required.',
                'content_validation_rule_id' => 'The content validation rule id field is required.',
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
                'content_type_id'            => $model->content_type_id,
                'content_validation_rule_id' => $model->content_validation_rule_id,
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_validation_rule_id' => 'The content validation rule id has already been taken.',
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
                'content_type_id'            => [Str::random(8)],
                'content_validation_rule_id' => [Str::random(8)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_type_id'            => 'The content type id must be an integer.',
                'content_validation_rule_id' => 'The content validation rule id must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function content_validation_rule_id_exists_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $deleted_model = ContentValidationRule::factory()
            ->softDeleted()
            ->create();

        // Test random id invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_validation_rule_id' => rand(1000, 9999),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'content_validation_rule_id' => 'The selected content validation rule id is invalid.',
            ]);

        // Test deleted content validation rule invalid
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'content_validation_rule_id' => $deleted_model->id,
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
    public function content_type_id_exists_validation(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $deleted_model = ContentType::factory()->softDeleted()->create();

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
                'content_type_id' => $deleted_model->id,
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
    public function successful_store(): void
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->emailVerified()->dev()->create();
        $data = call_user_func($this->model_classname.'::factory')->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200);

        $model = app()->make($this->repository_classname)->findLast();

        $response->assertJson([
            'success'  => true,
            'resource' => [
                'id'                         => $model->id,
                'created_at'                 => $model->created_at->toISOString(),
                'content_type_id'            => $data['content_type_id'],
                'content_validation_rule_id' => $data['content_validation_rule_id'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf(ContentType::class, $model->content_type);
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
