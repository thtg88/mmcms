<?php

namespace Thtg88\MmCms\Tests\Feature\ContentTypeContentValidationRule;

use Thtg88\MmCms\Models\ContentTypeContentValidationRule;
use Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentTypeContentValidationRule::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentTypeContentValidationRuleRepository::class;
}
