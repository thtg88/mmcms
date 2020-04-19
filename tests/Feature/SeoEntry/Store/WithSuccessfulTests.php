<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry\Store;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;

trait WithSuccessfulTests
{
    /**
     * @return void
     * @group crud
     * @test
     */
    public function empty_payload_has_required_validation_errors(): void
    {
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute());
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'target_id' => 'The target id field is required.',
                'target_table' => 'The target table field is required.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function strings_validation_errors(): void
    {
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'facebook_description' => [Str::random(5)],
                'facebook_image' => [Str::random(5)],
                'facebook_title' => [Str::random(5)],
                'json_schema' => [Str::random(5)],
                'meta_description' => [Str::random(5)],
                'meta_robots_follow' => [Str::random(5)],
                'meta_robots_index' => [Str::random(5)],
                'meta_title' => [Str::random(5)],
                'page_title' => [Str::random(5)],
                'twitter_description' => [Str::random(5)],
                'twitter_image' => [Str::random(5)],
                'twitter_title' => [Str::random(5)],
                'target_table' => [Str::random(5)],
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'facebook_description' => 'The facebook description must be a string.',
                'facebook_image' => 'The facebook image must be a string.',
                'facebook_title' => 'The facebook title must be a string.',
                'json_schema' => 'The json schema must be a string.',
                'meta_description' => 'The meta description must be a string.',
                'meta_robots_follow' => 'The meta robots follow must be a string.',
                'meta_robots_index' => 'The meta robots index must be a string.',
                'meta_title' => 'The meta title must be a string.',
                'page_title' => 'The page title must be a string.',
                'twitter_description' => 'The twitter description must be a string.',
                'twitter_image' => 'The twitter image must be a string.',
                'twitter_title' => 'The twitter title must be a string.',
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
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
                'facebook_description' => Str::random(256),
                'facebook_image' => Str::random(2001),
                'facebook_title' => Str::random(256),
                'meta_description' => Str::random(256),
                'meta_robots_follow' => Str::random(256),
                'meta_robots_index' => Str::random(256),
                'meta_title' => Str::random(256),
                'page_title' => Str::random(256),
                'twitter_description' => Str::random(256),
                'twitter_image' => Str::random(2001),
                'twitter_title' => Str::random(256),
            ]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'facebook_description' => 'The facebook description may not be greater than 255 characters.',
                'facebook_image' => 'The facebook image may not be greater than 2000 characters.',
                'facebook_title' => 'The facebook title may not be greater than 255 characters.',
                'meta_description' => 'The meta description may not be greater than 255 characters.',
                'meta_robots_follow' => 'The meta robots follow may not be greater than 255 characters.',
                'meta_robots_index' => 'The meta robots index may not be greater than 255 characters.',
                'meta_title' => 'The meta title may not be greater than 255 characters.',
                'page_title' => 'The page title may not be greater than 255 characters.',
                'twitter_description' => 'The twitter description may not be greater than 255 characters.',
                'twitter_image' => 'The twitter image may not be greater than 2000 characters.',
                'twitter_title' => 'The twitter title may not be greater than 255 characters.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function valid_target_table_errors(): void
    {
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), [
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
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), ['target_id' => [Str::random(8)]]);
        $response->assertStatus(422)
            ->assertJsonValidationErrors([
                'target_id' => 'The target id must be an integer.',
            ]);
    }

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_store(): void
    {
        $user = factory(User::class)->states('email_verified', $this->getUserRoleFactoryStateName())
            ->create();
        $data = factory($this->model_classname)->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(200);

        $model = app()->make($this->repository_classname)->findLast();

        $response->assertJson([
            'success' => true,
            'resource' => [
                'id' => $model->id,
                'target_table' => $data['target_table'],
            ],
        ]);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
