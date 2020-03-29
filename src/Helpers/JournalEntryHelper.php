<?php

namespace Thtg88\MmCms\Helpers;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Thtg88\MmCms\Repositories\JournalEntryRepository;

/**
 * Helper methods for journal entry.
 */
class JournalEntryHelper
{
    /**
     * The journal entry repo implementation.
     *
     * @var \Thtg88\MmCms\Repositories\JournalEntryRepository
     */
    protected $journal_entries;

    /**
     * The current request IP.
     *
     * @var string	$current_request_ip
     */
    protected $current_request_ip;

    /**
     * Create a new helper instance.
     *
     * @param \Thtg88\MmCms\Repositories\JournalEntryRepository $journal_entries
     * @param string $current_request_ip
     * @return void
     */
    public function __construct(
        JournalEntryRepository $journal_entries,
        $current_request_ip
    ) {
        $this->journal_entries = $journal_entries;
        $this->current_request_ip = $current_request_ip;
    }

    /**
     * Create a new journal entry instance in storage.
     *
     * @param	string	$action	The action performing while creating the entry.
     * @param	Illuminate\Database\Eloquent\Model	$model	The model the action is performed on.
     * @param	array	$content	The action content data.
     * @return	\Thtg88\MmCms\JournalEntry
     */
    public function createJournalEntry($action, Model $model, array $content = null)
    {
        if ($model !== null) {
            // Get model class name
            $class_name = get_class($model);

            // Get morph map
            $morph_map = Relation::morphMap();

            // Get target table for model
            $target_table = array_search($class_name, $morph_map);
            if ($target_table === false) {
                $target_table = null;
            }

            $id = $model->id;
        } else {
            $target_table = null;
            $id = null;
        }

        // Get current authenticated user
        $user = Auth::user();

        // Build data array to save journal entry
        $data = [];
        $data['target_id'] = $id;
        if ($user !== null) {
            $data['user_id'] = $user->id;
        }
        $data['user_ip_address'] = $this->current_request_ip;
        $data['action'] = $action;
        $data['target_table'] = $target_table;
        if ($content === null) {
            $data['content'] = null;
        } else {
            $data['content'] = json_encode($content);
        }

        return $this->journal_entries->create($data);
    }
}
