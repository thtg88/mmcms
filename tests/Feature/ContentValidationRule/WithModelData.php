<?php

namespace Thtg88\MmCms\Tests\Feature\ContentValidationRule;

use Thtg88\MmCms\Models\ContentValidationRule;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = ContentValidationRule::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = ContentValidationRuleRepository::class;
}
