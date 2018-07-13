<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\Role;

/**
 *
 */
class RoleRepository extends Repository
{
    protected static $model_name = 'name';

    protected static $eager_load_associations = [
        //
    ];

    protected static $order_by_columns = [
        'name' => 'asc',
    ];

    protected static $search_columns = [
        'name',
    ];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\Role     $role
     * @return  void
     */
    public function __construct(Role $role)
    {
        $this->model = $role;

        parent::__construct();
    }
}
