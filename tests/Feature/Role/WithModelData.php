<?php

namespace Thtg88\MmCms\Tests\Feature\Role;

use Thtg88\MmCms\Models\Role;
use Thtg88\MmCms\Repositories\RoleRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = Role::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = RoleRepository::class;
}
