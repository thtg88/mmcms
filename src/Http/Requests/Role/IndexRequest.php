<?php

namespace Thtg88\MmCms\Http\Requests\Role;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\Role;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = Role::class;
}
