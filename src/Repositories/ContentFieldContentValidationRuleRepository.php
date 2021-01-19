<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\ContentFieldContentValidationRule;

class ContentFieldContentValidationRuleRepository extends Repository
{
    protected static $model_name = 'id';

    protected static $order_by_columns = [
        'id' => 'asc',
    ];

    protected static $search_columns = [];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\ContentFieldContentValidationRule $model
     *
     * @return void
     */
    public function __construct(ContentFieldContentValidationRule $model)
    {
        $this->model = $model;

        parent::__construct();
    }
}
