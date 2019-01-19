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
     * @param \Thtg88\MmCms\Models\JournalEntry     $journal_entry
     * @return  void
     */
    public function __construct(JournalEntry $journal_entry)
    {
        $this->model = $journal_entry;

        parent::__construct();
    }
}
