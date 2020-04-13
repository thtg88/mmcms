<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Thtg88\MmCms\Models\ImageCategory;
use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ImageCategory::class;
}
