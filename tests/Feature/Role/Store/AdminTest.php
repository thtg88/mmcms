<?php

namespace Thtg88\MmCms\Tests\Feature\Role\Store;

use Thtg88\MmCms\Models\User;
use Illuminate\Support\Str;
use Thtg88\MmCms\Tests\Contracts\StoreTest as StoreTestContract;
use Thtg88\MmCms\Tests\Feature\Role\WithModelData;
use Thtg88\MmCms\Tests\Feature\TestCase;

class AdminTest extends TestCase implements StoreTestContract
{
    use WithModelData, WithUrl;

    /**
     * Test an empty payload has required validation errors.
     *
     * @return void
     * @group crud
     */
    public function testEmptyPayloadHasRequiredValidationErrors()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $response = $this->passportActingAs($user)->json('post', $this->getRoute());
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name field is required.',
        ]);
    }

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
        $response = $this->passportActingAs($user)->json('post', $this->getRoute(), [
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
        $response = $this->passportActingAs($user)->json('post', $this->getRoute(), [
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

        $response = $this->passportActingAs($user)->json('post', $this->getRoute(), [
            'name' => $model->name,
        ]);
        $response->assertStatus(302);
        $response->assertSessionHasErrors([
            'name' => 'The name has already been taken.',
        ]);
    }

    /**
     * Test successful store.
     *
     * @return void
     * @group crud
     */
    public function testSuccessfulStore()
    {
        $user = factory(User::class)->states('email_verified', 'admin')
            ->create();
        $data = factory($this->model_classname)->raw();

        $response = $this->passportActingAs($user)
            ->json('post', $this->getRoute(), $data);
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();

        $model = app()->make($this->repository_classname)
            ->findByModelName($data['name']);

        $this->assertTrue($model !== null);
        $this->assertInstanceOf($this->model_classname, $model);
        // Check all attributes match
        foreach ($data as $key => $value) {
            $this->assertEquals($data[$key], $model->$key);
        }
    }
}
