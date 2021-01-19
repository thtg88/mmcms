<?php

namespace Thtg88\MmCms\Tests\Feature\ContentField\Destroy;

use Illuminate\Container\Container;
use Thtg88\MmCms\Events\ContentFieldStored;
use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Tests\Feature\Concerns\Destroy\ActingAsDevTest;
use Thtg88\MmCms\Tests\Feature\Concerns\WithGeneratedFiles;
use Thtg88\MmCms\Tests\Feature\ContentField\WithModelData;
use Thtg88\MmCms\Tests\Feature\Contracts\DestroyTest as DestroyTestContract;
use Thtg88\MmCms\Tests\Feature\TestCase;

class DevTest extends TestCase implements DestroyTestContract
{
    use WithModelData;
    use WithUrl;
    use ActingAsDevTest;
    use WithGeneratedFiles;

    /**
     * @return void
     * @group crud
     * @test
     */
    public function successful_destroy(): void
    {
        $user = User::factory()->emailVerified()->dev()->create();
        $model = call_user_func($this->model_classname.'::factory')->create();
        $model_migration_time = $this->getLatestMigratingMigrationTimestamp();

        Container::getInstance()->make('events', [])
            ->dispatch(new ContentFieldStored($model));
        $add_column_migration_time = $this->getLatestMigratingMigrationTimestamp();

        $response = $this->passportActingAs($user)
            ->json('delete', $this->getRoute([$model->id]));
        $remove_column_migration_time = $this->getLatestMigratingMigrationTimestamp();
        $response->assertStatus(200)
            ->assertJsonMissing(['errors' => []])
            ->assertJson([
                'resource' => [
                    'id'         => $model->id,
                    'created_at' => $model->created_at->toISOString(),
                ],
            ]);

        $this->assertTrue($model->refresh()->deleted_at !== null);
        $this->assertNull(
            app()->make($this->repository_classname)
                ->find($model->id)
        );

        $this->generated_files = [
            database_path(
                'migrations'.DIRECTORY_SEPARATOR.$remove_column_migration_time.
                '_remove_'.$model->name.'_column_from_'.
                $model->content_model->table_name.'_table.php'
            ),
        ];
        $this->assertGeneratedFilesExist();
    }
}
