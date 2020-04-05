<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Update;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Concerns\Update\ActingAsAdminTest;
use Thtg88\MmCms\Tests\Contracts\UpdateTest as UpdateTestContract;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements UpdateTestContract
{
    use WithModelData, WithUrl, ActingAsAdminTest;

    /**
     * Test strings validation errors.
     *
     * @return void
     * @group crud
     */
    public function testStringsValidationErrors()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->put($this->getRoute([$model->id]), [
            'name' => [Str::random(5)],
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name must be a string.',
        ]);
    }

    /**
     * Test too long strings have max length validation errors.
     *
     * @return void
     * @group crud
     */
    public function testTooLongStringsHaveMaxValidationErrors()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->put($this->getRoute([$model->id]), [
            'name' => Str::random(256),
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name may not be greater than 255 characters.',
        ]);
    }

    /**
     * Test name unique validation.
     *
     * @return void
     * @group crud
     */
    public function testUniqueValidation()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();
        $other_model = factory($this->model_classname)->create();

        $response = $this->actingAs($user)->put($this->getRoute([$model->id]), [
            'name' => $other_model->name,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);
    }

    /**
     * Test successful update.
     *
     * @return void
     * @group crud
     */
    public function testSuccessfulUpdate()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $model = factory($this->model_classname)->create();

        $data = factory($this->model_classname)->raw();

        $response = $this->actingAs($user)
            ->put($this->getRoute([$model->id]), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $model = $model->refresh();

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
