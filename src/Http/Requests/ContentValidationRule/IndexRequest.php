<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\ContentValidationRule;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ContentValidationRule::class;
}
