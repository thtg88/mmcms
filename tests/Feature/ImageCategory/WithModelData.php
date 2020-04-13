<?php

namespace Thtg88\MmCms\Tests\Feature\ImageCategory;

use Thtg88\MmCms\Models\ImageCategory;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ImageCategory::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ImageCategoryRepository::class;
}
