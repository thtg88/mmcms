<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\User;

class UserRepository extends Repository
{
    /**
     * The column to treat as the model name.
     *
     * @var string
     */
    protected static $model_name = 'email';

    /**
     * The columns to which perform the sorting on.
     *
     * @var array
     */
    protected static $order_by_columns = [
        'name' => 'asc',
        'email' => 'asc',
        'id' => 'asc',
    ];

    /**
     * The columns to which perform the search on.
     *
     * @var array
     */
    protected static $search_columns = [
        'email',
        'name',
    ];

    /**
     * The columns to which perform filtering on.
     *
     * @var array
     */
    protected static $filter_columns = [];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\User $model
     * @return void
     */
    public function __construct(User $model)
    {
        $this->model = $model;

        parent::__construct();
    }
}
