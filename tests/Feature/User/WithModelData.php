<?php

namespace Thtg88\MmCms\Tests\Feature\User;

use Thtg88\MmCms\Models\User;
use Thtg88\MmCms\Repositories\UserRepository;

trait WithModelData
{
    /**
     * The model class name.
     *
     * @var string
     */
    protected $model_classname = User::class;

    /**
     * The repository class name.
     *
     * @var string
     */
    protected $repository_classname = UserRepository::class;
}
