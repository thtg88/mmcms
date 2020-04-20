<?php

namespace Thtg88\MmCms\Tests\Feature\ContentModel;

use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Repositories\ContentModelRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentModel::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentModelRepository::class;
}
