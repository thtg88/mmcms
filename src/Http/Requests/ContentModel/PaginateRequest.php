<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Thtg88\MmCms\Http\Requests\PaginateRequest as BasePaginateRequest;
use Thtg88\MmCms\Models\ContentModel;

class PaginateRequest extends BasePaginateRequest
{
    /** @var string */
    protected $model_classname = ContentModel::class;
}
