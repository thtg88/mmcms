<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\ContentType;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ContentType::class;
}
