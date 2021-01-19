<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ContentValidationRule;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ContentValidationRule::class;
}
