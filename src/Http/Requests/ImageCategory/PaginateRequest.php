<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ImageCategory;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ImageCategory::class;
}
