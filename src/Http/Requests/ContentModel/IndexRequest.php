<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\ContentModel;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ContentModel::class;
}
