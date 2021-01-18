<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;
use Thtg88\MmCms\Models\SeoEntry;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = SeoEntry::class;
}
