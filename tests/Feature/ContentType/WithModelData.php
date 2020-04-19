<?php

namespace Thtg88\MmCms\Tests\Feature\ContentType;

use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentType::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentTypeRepository::class;
}
