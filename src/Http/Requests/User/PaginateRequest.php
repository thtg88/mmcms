<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = User::class;
}
