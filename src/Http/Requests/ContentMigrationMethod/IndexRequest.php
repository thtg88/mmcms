<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

use Thtg88\MmCms\Models\ContentMigrationMethod;
use Thtg88\MmCms\Http\Requests\IndexRequest as BaseIndexRequest;

class IndexRequest extends BaseIndexRequest
{
    /** @var string */
    protected $model_classname = ContentMigrationMethod::class;
}
