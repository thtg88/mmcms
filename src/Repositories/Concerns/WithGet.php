<?php

namespace Thtg88\MmCms\Repositories\Concerns;

use DateTime;
use Illuminate\Database\Eloquent\Collection;

trait WithGet
{
    /**
     * Return all the resources from given ids.
     *
     * @param array $ids The ids of the resources to return.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getByIds(array $ids)
    {
        // Filter out empty and non-numeric ids
        $ids = array_filter(
            $ids,
            static function ($id) {
                return is_numeric($id) && ! empty($id);
            }
        );

        // If no ids, return empty set
        if (empty($ids)) {
            return new Collection();
        }

        $result = $this->model->whereIn('id', $ids);

        $result = $this->withOptionalTrashed($result);

        $result = $this->withDefaultOrderBy($result);

        return $result->get();
    }

    /**
     * Return all the resources belonging to a given user id.
     *
     * @param int $user_id The id of the user.
     * @return \Illuminate\Support\Collection
     */
    public function getByUserId($user_id)
    {
        // Assume id as numeric and > 0
        if (empty($user_id) || ! is_numeric($user_id) || $user_id <= 0) {
            return new Collection();
        }

        $result = $this->model->where('user_id', $user_id);

        $result = $this->withOptionalTrashed($result);

        $result = $this->withDefaultOrderBy($result);

        return $result->get();
    }

    /**
     * Return the given number of latest inserted model instances.
     *
     * @param int $limit The number of model instances to return.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function latest($limit)
    {
        $result = $this->model;

        $result = $this->withOptionalTrashed($result);

        return $result->latest()
            ->take($limit)
            ->get();
    }
}
