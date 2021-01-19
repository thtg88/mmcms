<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\SeoEntry;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = SeoEntry::class;
}
