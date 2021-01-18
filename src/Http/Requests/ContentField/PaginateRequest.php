<?php

namespace Thtg88\MmCms\Http\Requests\ContentField;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ContentField;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ContentField::class;
}
