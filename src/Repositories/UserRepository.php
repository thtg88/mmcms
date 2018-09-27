<?php

namespace Thtg88\MmCms\Repositories;

use Carbon\Carbon;
use Thtg88\MmCms\Models\User;

/**
*
*/
class UserRepository extends Repository
{
    protected static $model_name = 'email';

    protected static $order_by_columns = [
        'name' => 'asc',
        'email' => 'asc',
        'id' => 'asc',
    ];

    protected static $search_columns = [
        'email',
        'name',
    ];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\User     $user
     * @return  void
     */
    public function __construct(User $user)
    {
        $this->model = $user;

        parent::__construct();
    }
}
