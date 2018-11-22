<?php

namespace Thtg88\MmCms\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;

class Repository implements RepositoryInterface
{
    /**
     * The repository model.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * The columns to use for date filtering.
     *
     * @var array
     */
    protected static $date_filter_columns;

    /**
     * The column to treat as the model name.
     *
     * @var string
     * @TODO expand to include multiple column functionality. Perhaps allow array, with separator additional parameter, or closure.
     */
    protected static $model_name;

    /**
     * The columns to which perform the sorting on.
     *
     * @var array
     */
    protected static $order_by_columns;

    /**
     * The columns to which perform the search on.
     *
     * @var array
     */
    protected static $search_columns;

    public function __construct()
    {
        // Get model class name
        $class_name = get_class($this->model);

        // Get target table for model
        $target_table = $this->model->getTable();

        // Merge into morph map for accessibility across the Thtg88\MmCms when retrieving
        Relation::morphMap([
            $target_table => $class_name,
        ]);
    }

    /**
     * Return the table associated with the repository model.
     *
     * @return string
     */
    public function getName()
    {
        return $this->model->getTable();
    }

    /**
     * Return the associations to eager load with the repository model.
     *
     * @return array
     */
    public function getEagerLoadAssociations()
    {
        return $this->model->getWith();
    }

    /**
     * Return the associations to eager load with the repository model.
     *
     * @return array
     */
    public function getOrderByColumns()
    {
        return static::$order_by_columns;
    }

    /**
     * Return all the model instances.
     *
     * @return  \Illuminate\Support\Collection
     */
    public function all()
    {
        $result = $this->model;

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->get();
    }

    /**
     * Return all the model instances in a compact array form (id as index, name as value).
     *
     * @return array
     */
    public function allCompact()
    {
        $result = $this->model->select('id', static::$model_name);

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        $temp_models = $result->get();

        $models = [];
        foreach($temp_models as $idx => $model)
        {
            $models[$model->id] = $model->{static::$model_name};
        }

        return $models;
    }

    /**
     * Create a new model instance in storage.
     *
     * @param       array   $data
     * @return      \Illuminate\Database\Eloquent\Model
     */
    public function create(array $data)
    {
        // Set created time string
        if(isset($data['created_at']) === FALSE || empty($data['created_at']))
        {
            $data['created_at'] = app('now')->copy()->toDateTimeString();
        }

        // Create model
        $model = $this->model->create($data);

        // Re-find model in order to load relationships and getting all the data
        if($model !== null)
        {
            $model = $this->find($model->id);
        }

        if(config('mmcms.journal.mode') === true)
        {
            // Create journal entry only if not creating journal entry, lol (infinite recursion)
            $journal_entry_class_name = '\Thtg88\MmCms\Models\JournalEntry';
            if($model instanceof $journal_entry_class_name === false)
            {
                app('JournalEntryHelper')->createJournalEntry(null, $model, $data);
            }
        }

        return $model;
    }

    /**
     * Deletes a model instance from a given id.
     *
     * @param int $id The id of the model.
     * @return int
     */
    public function destroy($id)
    {
        // Get model
        $model = $this->find($id);
        if($model === null)
        {
            return null;
        }

        // Check if a model uses discards, so I can log into journal
        if(in_array('Illuminate\Database\Eloquent\SoftDelete', class_uses($this->model)))
        {
            if(config('mmcms.journal.mode') === true)
            {
                app('JournalEntryHelper')->createJournalEntry('discard', $model, []);
            }
        }

        $response = $this->model->destroy($id);

        return $model;
    }

    /**
     * Returns a model from a given id.
     *
     * @param int $id The id of the instance.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function find($id)
    {
        // Assume id as numeric and > 0
        if(empty($id) || !is_numeric($id))
        {
            return null;
        }

        return $this->model->find($id);
    }

    /**
     * Returns a model from a given model name.
     *
     * @param mixed $model_name The model name of the instance.
     * @return \Illuminate\Database\Eloquent\Model
     * @TODO expand to include multiple column functionality. Perhaps allow array, with separator additional parameter, or closure.
     */
    public function findByModelName($model_name)
    {
        // Assume id as numeric and > 0
        if(empty($model_name) || !isset(static::$model_name))
        {
            return null;
        }

        // Get model
        return $this->model->where(static::$model_name, $model_name)
            ->first();
    }

    /**
     * Returns a random model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findRandom()
    {
        // Get model
        return $this->model->inRandomOrder()
            ->first();
    }

    /**
     * Return all the resources between a given start and end date.
     * This methods treats the date filter differently depending
     * on the number of columns specified in $date_filter_columns:
     * 0. No date filtering is applied - the result is identical to getByUserId
     * 1. The filter is applied in the form of $start_date <= $date_filter_columns[0] < $end_date
     * 2. The columns are considered to be an interval. Therefore the filter
     * checks if date intervals are overlapping (excluding the edges), in the form:
     * $start_date < $date_filter_columns[1] && $end_date > $date_filter_columns[0]
     * >2. If more than 2 columns are specified, the ones after the second
     * are ignored, and scenario 2 applies.
     *
     * @param       \Carbon\Carbon  $start_date     The start date.
     * @param       \Carbon\Carbon  $end_date       The end date.
     * @return      \Illuminate\Support\Collection
     */
    public function getByDateFilter(Carbon $start_date, Carbon $end_date)
    {
        if(!isset(static::$date_filter_columns) || !is_array(static::$date_filter_columns))
        {
            // If no date filter columns set
            return collect([]);
        }

        // Get total elements of the date filter columns array
        $total_date_filter_columns = count(static::$date_filter_columns);

        switch($total_date_filter_columns) {
            case 0:
                // Nothing to filter on
                break;
            case 1:
                // The filter is applied in the form of $start_date <= $date_filter_columns[0] < $end_date
                $result = $this->model->where(static::$date_filter_columns[0], '>=', $start_date->toDateTimeString())
                    ->where(static::$date_filter_columns[0], '<', $end_date->toDateTimeString());
                break;
            case 2:
            default:
                // Check if date intervals are overlapping (excluding the edges)
                // $date_filter_columns[0] < $end_date && $date_filter_columns[1] > $start_date
                $result = $this->model->where(static::$date_filter_columns[0], '<', $end_date)
                    ->where(static::$date_filter_columns[1], '>', $start_date);
                break;
        }

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->get();
    }

    /**
     * Return all the resources belonging to a given user id.
     *
     * @param       int     $user_id        The id of the user.
     * @return      \Illuminate\Support\Collection
     */
    public function getByUserId($user_id)
    {
        // Assume id as numeric and > 0
        if(empty($user_id) || !is_numeric($user_id))
        {
            return collect([]);
        }

        $result = $this->model->where('user_id', $user_id);

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->get();
    }

    /**
     * Return all the resources belonging to a given user id,
     * and between a given start and end date.
     * This methods treats the date filter differently depending
     * on the number of columns specified in $date_filter_columns:
     * 0. No date filtering is applied - the result is identical to getByUserId
     * 1. The filter is applied in the form of $start_date <= $date_filter_columns[0] < $end_date
     * 2. The columns are considered to be an interval. Therefore the filter
     * checks if date intervals are overlapping (excluding the edges), in the form:
     * $start_date < $date_filter_columns[1] && $end_date > $date_filter_columns[0]
     * >2. If more than 2 columns are specified, the ones after the second
     * are ignored, and scenario 2 applies.
     *
     * @param       int     $user_id        The id of the user.
     * @param       \Carbon\Carbon  $start_date     The start date.
     * @param       \Carbon\Carbon  $end_date       The end date.
     * @return      \Illuminate\Support\Collection
     */
    public function getByUserIdAndDateFilter($user_id, Carbon $start_date, Carbon $end_date)
    {
        // Assume id as numeric and > 0
        if(empty($user_id) || !is_numeric($user_id))
        {
            return collect([]);
        }

        if(!isset(static::$date_filter_columns) || !is_array(static::$date_filter_columns))
        {
            // If no date filter columns set
            return collect([]);
        }

        $result = $this->model->where('user_id', $user_id);

        // Get total elements of the date filter columns array
        $total_date_filter_columns = count(static::$date_filter_columns);

        switch($total_date_filter_columns) {
            case 0:
                // Nothing to filter on
                break;
            case 1:
                // The filter is applied in the form of $start_date <= $date_filter_columns[0] < $end_date
                $result = $result->where(static::$date_filter_columns[0], '>=', $start_date->toDateTimeString())
                    ->where(static::$date_filter_columns[0], '<', $end_date->toDateTimeString());
                break;
            case 2:
            default:
                // Check if date intervals are overlapping (excluding the edges)
                // $date_filter_columns[0] < $end_date && $date_filter_columns[1] > $start_date
                $result = $result->where(static::$date_filter_columns[0], '<', $end_date)
                    ->where(static::$date_filter_columns[1], '>', $start_date);
                break;
        }

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->get();
    }

    /**
     * Return the given number of latest inserted model instances.
     *
     * @param       int     $limit  The number of model instances to return
     * @return  \Illuminate\Support\Collection
     */
    public function latest($limit)
    {
        // Assume id as numeric and > 0
        if(empty($limit) || !is_numeric($limit))
        {
            return collect([]);
        }

        return $this->model->latest()
            ->take($limit)
            ->get();
    }

    /**
     * Return the paginated model instances.
     *
     * @param       int     $page_size  The number of model instances to return per page
     * @param       int     $page  The page number
     * @param       int     $page  The optional search query
     * @return  \Illuminate\Support\Collection
     */
    public function paginate($page_size = 10, $page = null, $q = null)
    {
        // Assume page_size as numeric and > 0
        if(empty($page_size) || !is_numeric($page_size) || $page_size < 1)
        {
            return collect([]);
        }

        // Assume page as numeric and > 0
        if(!empty($page) && (!is_numeric($page) || $page < 1))
        {
            return collect([]);
        }

        $page_size = floor($page_size);
        $page = floor($page);

        $result = $this->model;

        // Search clause
        if(!empty($q))
        {
            $result = $this->model->where(function ($query) use($q) {
                foreach(static::$search_columns as $idx => $column)
                {
                    $query->orWhere($column, 'LIKE', '%'.$q.'%');
                }
            });
        }

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->paginate($page_size, config('mmcms.pagination.columns'), config('mmcms.pagination.page_name'), $page);
    }

    /**
     * Return the model instances matching the given search query.
     *
     * @param       string  $q      The search query.
     * @return      \Illuminate\Support\Collection
     */
    public function search($q)
    {
        // If empty query or no search columns provided
        if($q === null || $q === '')
        {
            // Return empty collection
            return collect([]);
        }

        // If no search columns provided
        if(!is_array(static::$search_columns) || count(static::$search_columns) <= 0)
        {
            // Return empty collection
            return collect([]);
        }

        // Search clause
        $result = $this->model->where(function ($query) use($q) {
            foreach(static::$search_columns as $idx => $column)
            {
                $query->orWhere($column, 'LIKE', '%'.$q.'%');
            }
        });

        // Order by clause
        if(is_array(static::$order_by_columns) && count(static::$order_by_columns) > 0)
        {
            foreach(static::$order_by_columns as $order_by_column => $direction)
            {
                $result = $result->orderBy($order_by_column, $direction);
            }
        }

        return $result->get();
    }

    /**
     * Updates a model instance with given data, from a given id.
     *
     * @param       int     $id The id of the model
     * @param       array   $data
     * @return      \Illuminate\Database\Eloquent\Model
     */
    public function update($id, array $data)
    {
        // Get model
        $model = $this->find($id);

        if($model === null)
        {
            return null;
        }

        // Get rid of unnecessary data e.g. not changed or not in the model
        $data = $this->pruneData($data, $model);

        if(count($data) == 0)
        {
            // No data changed - No need to fire an update
            return $model;
        }

        // Save data
        $result = $model->fill($data)->save();

        // Re-fetch the model to reload all relations
        $model = $this->find($model->id);

        if(config('mmcms.journal.mode') === true)
        {
            // Create journal entry only if not creating journal entry, lol (infinite recursion)
            $journal_entry_class_name = '\Thtg88\MmCms\Models\JournalEntry';
            if($model instanceof $journal_entry_class_name === false)
            {
                app('JournalEntryHelper')->createJournalEntry(null, $model, $data);
            }
        }

        return $model;
    }

    /**
     * Filter out data that would not change the state of the model.
     *
     * @param       array   $data   The data to set.
     * @param       \Illuminate\Database\Eloquent\Model     $model  The model to update.
     * @param       array   $exclude        A set of columns to exclude from the prune e.g. if the update is meant to update associations as well.
     * @return      array
     */
    protected function pruneData(array $data, Model $model, array $exclude = array())
    {
        // Get the model fillables
        $model_fillables = $model->getFillable();

        // Get all original model values
        $actual_model_values = array_merge($model->getAttributes(), $model->getHidden());

        // Get rid of not original model attributes (e.g. eager-loaded relationships and appended attributes)
        $model_values = array_intersect_key($actual_model_values, array_flip($model_fillables));

        // Gets rid of columns that needs to be excluded by the prune
        $data = array_diff_key($data, array_flip($exclude));

        foreach($data as $column => $value)
        {
            if(!array_key_exists($column, $model_values))
            {
                // If there is no such column in the original model - discard
                unset($data[$column]);
            }
            else if($model_values[$column] == $value)
            {
                // If the 2 values are the same - discard
                unset($data[$column]);
            }
        }

        return $data;
    }
}
