<?php

namespace Thtg88\MmCms\Tests\Feature\ContentFieldContentValidationRule;

use Thtg88\MmCms\Models\ContentFieldContentValidationRule;
use Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentFieldContentValidationRule::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentFieldContentValidationRuleRepository::class;
}
