<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\Role;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = Role::class;
}
