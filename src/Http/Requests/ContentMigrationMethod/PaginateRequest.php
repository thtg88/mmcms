<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ContentMigrationMethod;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ContentMigrationMethod::class;
}
