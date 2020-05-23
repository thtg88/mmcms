<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Thtg88\MmCms\Http\Requests\SearchRequest as BaseSearchRequest;
use Thtg88\MmCms\Models\ContentValidationRule;

class SearchRequest extends BaseSearchRequest
{
    /** @var string */
    protected $model_classname = ContentValidationRule::class;
}
