<?php

namespace Thtg88\MmCms\Tests\Feature\ContentMigrationMethod;

use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentMigrationMethod::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentMigrationMethodRepository::class;
}
