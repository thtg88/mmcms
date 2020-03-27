<?php

namespace Thtg88\MmCms\Repositories\Concerns;

use App\Models\JournalEntry;
use DB;
use Illuminate\Support\Facades\Config;

trait WithCreate
{
    /**
     * Create a new model instance in storage from the given data array.
     *
     * @param array $data
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // Create model
        $model = $this->model->create($data);

        if (Config::get('app.journal_mode') === true) {
            // Create journal entry only if not creating journal entry, lol (infinite recursion)
            $journal_entry_classname = JournalEntry::class;

            if (
                $model !== null &&
                $model instanceof $journal_entry_classname === false
            ) {
                app('JournalEntryHelper')->createJournalEntry(
                    'create',
                    $model,
                    $data
                );
            }
        }

        // Get model key name
        $model_key = $model->getKeyName();

        return $this->find($model->{$model_key});
    }

    /**
     * Create a bulk of new model instances in storage from the given data array.
     * Returns true on success, false on failure.
     *
     * @param array $data
     * @return bool
     */
    public function createBulk(array $data)
    {
        // Get model fillables and
        // flip them to intersect as keys against model data
        // To avoid unwanted mass assignment
        $flipped_fillable = array_flip($this->model->getFillable());

        foreach ($data as $idx => $model_data) {
            $data[$idx] = array_intersect_key($model_data, $flipped_fillable);

            // Add created_at and updated_at automatically
            $data[$idx][$this->model::CREATED_AT] = now();
            $data[$idx][$this->model::UPDATED_AT] = now();
        }

        // Chunk inserts to a max of 500 items
        // to avoid hitting issues on certain DBs
        $chunked_data = array_chunk(
            $data,
            Config::get('app.create_bulk_chunk_size'),
            true
        );

        foreach ($chunked_data as $_data) {
            // Insert data
            $result = DB::table($this->model->getTable())->insert($_data);

            if ($result === false) {
                return false;
            }
        }

            app('JournalEntryHelper')->createJournalEntry(
        if (Config::get('app.journal_mode') === true) {
                'create-bulk',
                null,
                [
                    'target_table' => $this->model->getTable(),
                    'data' => $data,
                ]
            );
        }

        return true;
    }
}
