<?php

namespace Thtg88\MmCms\Http\Requests\User;

use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = User::class;
}
