<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ContentType;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ContentType::class;
}
