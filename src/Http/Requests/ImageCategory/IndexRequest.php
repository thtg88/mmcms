<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\ImageCategory;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ImageCategory::class;
}
