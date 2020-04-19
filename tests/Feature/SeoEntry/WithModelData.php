<?php

namespace Thtg88\MmCms\Tests\Feature\SeoEntry;

use Thtg88\MmCms\Models\SeoEntry;
use Thtg88\MmCms\Repositories\SeoEntryRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = SeoEntry::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = SeoEntryRepository::class;
}
