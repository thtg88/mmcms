<?php

namespace Thtg88\MmCms\Repositories\Concerns;

use DateTime;
use Illuminate\Database\Eloquent\Collection;

trait WithDateFilter
{
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
     * @param \DateTime $start_date The start date.
     * @param \DateTime $end_date The end date.
     * @return \Illuminate\Database\Support\Collection
     */
    public function dateFilter(
        DateTime $start_date,
        DateTime $end_date
    ): Collection {
        // If no date filter columns set
        if (
            ! isset(static::$date_filter_columns) ||
            ! is_array(static::$date_filter_columns)
        ) {
            return new Collection();
        }

        $result = $this->model;

        // Get total elements of the date filter columns array
        $total_date_filter_columns = count(static::$date_filter_columns);

        switch ($total_date_filter_columns) {
            case 0:
                // Nothing to filter on
                break;
            case 1:
                // The filter is applied in the form of
                // $start_date <= $date_filter_columns[0] < $end_date
                $result = $result->where(
                    static::$date_filter_columns[0],
                    '>=',
                    $start_date->toDateTimeString()
                )->where(
                    static::$date_filter_columns[0],
                    '<',
                    $end_date->toDateTimeString()
                );
                break;
            case 2:
            default:
                // Check if date intervals are overlapping (excluding the edges)
                // $date_filter_columns[0] < $end_date &&
                // $date_filter_columns[1] > $start_date
                $result = $result->where(
                    static::$date_filter_columns[0],
                    '<',
                    $end_date
                )->where(
                    static::$date_filter_columns[1],
                    '>',
                    $start_date
                );
                break;
        }

        $result = $this->withOptionalTrashed($result);

        $result = $this->withDefaultOrderBy($result);

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
     * @param int $user_id The id of the user.
     * @param \DateTime $start_date The start date.
     * @param \DateTime $end_date The end date.
     * @return \Illuminate\Database\Support\Collection
     */
    public function getByUserIdAndDateFilter(
        $user_id,
        DateTime $start_date,
        DateTime $end_date
    ): Collection {
        // Assume id as numeric and > 0
        if (empty($user_id) || !is_numeric($user_id)) {
            return new Collection();
        }

        // If no date filter columns set
        if (
            ! isset(static::$date_filter_columns) ||
            ! is_array(static::$date_filter_columns)
        ) {
            return new Collection();
        }

        $result = $this->model->where('user_id', $user_id);

        // Get total elements of the date filter columns array
        $total_date_filter_columns = count(static::$date_filter_columns);

        switch ($total_date_filter_columns) {
            case 0:
                // Nothing to filter on
                break;
            case 1:
                // The filter is applied in the form of $start_date <= $date_filter_columns[0] < $end_date
                $result = $result->where(
                    static::$date_filter_columns[0],
                    '>=',
                    $start_date->toDateTimeString()
                )->where(
                    static::$date_filter_columns[0],
                    '<',
                    $end_date->toDateTimeString()
                );
                break;
            case 2:
            default:
                // Check if date intervals are overlapping (excluding the edges)
                // $date_filter_columns[0] < $end_date && $date_filter_columns[1] > $start_date
                $result = $result->where(
                    static::$date_filter_columns[0],
                    '<',
                    $end_date
                )->where(
                    static::$date_filter_columns[1],
                    '>',
                    $start_date
                );
                break;
        }

        $result = $this->withOptionalTrashed($result);

        $result = $this->withDefaultOrderBy($result);

        return $result->get();
    }
}
