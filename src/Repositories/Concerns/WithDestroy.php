<?php

namespace Thtg88\MmCms\Repositories\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use Thtg88\MmCms\Models\JournalEntry;

trait WithDestroy
{
    /**
     * Deletes a model instance from a given id.
     *
     * @param int $id The id of the model.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function destroy($id): Model
    {
        // Get model
        $model = $this->find($id);

        if ($model === null) {
            return null;
        }

        $model->delete();

        // Check if a model uses soft deletes, so I can log into journal
        // We assume all models use SoftDeletes,
        // as it's defined in our Model class
        // The array check below will return false
        // as class_uses does not check the parent class
        // (where SoftDeletes will be imported)
        // if (
        //     in_array(
        //         'Illuminate\Database\Eloquent\SoftDeletes',
        //         class_uses($this->model)
        //     )
        // ) {
        if (Config::get('mmcms.journal_mode') === true) {
            $this->journal_entry_helper->createJournalEntry(
                'delete',
                $model
            );
        }
        // }

        return $model;
    }

    /**
     * Delete model instances from a given ids array.
     * Returns the number of records deleted.
     *
     * @param array $ids The ids of the model to destroy.
     *
     * @return int
     */
    public function destroyBulk(array $ids)
    {
        // Assume site id numeric, not empty and > 0
        $ids = array_filter(
            $ids,
            static function ($id) {
                return
                    !empty($id) &&
                    is_numeric($id) &&
                    $id > 0;
            }
        );
        if (count($ids) === 0) {
            return 0;
        }

        $response = $this->model->whereIn('id', $ids)
            ->delete();

        // Check if a model uses soft deletes, so I can log into journal
        // We assume all models use SoftDeletes,
        // as it's defined in our Model class
        // The array check below will return false
        // as class_uses does not check the parent class
        // (where SoftDeletes will be imported)
        // if (
        //     in_array(
        //         'Illuminate\Database\Eloquent\SoftDeletes',
        //         class_uses($this->model)
        //     )
        // ) {
        if (Config::get('mmcms.journal_mode') === true) {
            $this->journal_entry_helper->createJournalEntry(
                'delete-bulk',
                null,
                [
                    'target_table' => $this->model->getTable(),
                    'ids'          => $ids,
                ]
            );
        }
        // }

        return $response;
    }

    /**
     * Restore a model instance from a given id.
     *
     * @param int $id The id of the model
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function restore($id)
    {
        // Get model
        $model = $this->withTrashed()->find($id);

        if ($model === null) {
            return null;
        }

        // We assume all models use SoftDeletes,
        // as it's defined in our Model class
        // The array check below will return false
        // as class_uses does not check the parent class
        // (where SoftDeletes will be imported)
        // if (in_array('Illuminate\Database\Eloquent\SoftDeletes', class_uses($this->model)))
        // {
        // Restore model
        $model->restore();

        if (Config::get('mmcms.journal_mode') === true) {
            // Create journal entry only if not creating journal entry i.e. infinite recursion
            $journal_entry_classname = JournalEntry::class;

            if ($model instanceof $journal_entry_classname === false) {
                $this->journal_entry_helper->createJournalEntry(
                    'restore',
                    $model,
                    []
                );
            }
        }
        // }

        return $model;
    }
}
