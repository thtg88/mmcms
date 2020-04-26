<?php

namespace Thtg88\MmCms\Tests\Feature\ContentField;

use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Repositories\ContentFieldRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentField::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentFieldRepository::class;
}
