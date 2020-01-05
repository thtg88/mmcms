<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\Role;

/**
 *
 */
class RoleRepository extends Repository
{
    protected static $model_name = 'name';

    protected static $order_by_columns = [
        'name' => 'asc',
    ];

    protected static $search_columns = [
        'name',
    ];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\Role     $model
     * @return void
     */
    public function __construct(Role $model)
    {
        $this->model = $model;

        parent::__construct();
    }
}
