<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\JournalEntry;

/**
 *
 */
class JournalEntryRepository extends Repository
{
    protected static $model_name = 'id';

    protected static $order_by_columns = [
        'created_at' => 'desc',
    ];

    protected static $search_columns = [
        //
    ];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\JournalEntry     $model
     * @return void
     */
    public function __construct(JournalEntry $model)
    {
        $this->model = $model;

        parent::__construct();
    }
}
