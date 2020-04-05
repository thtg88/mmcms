<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = Role::class;
}
