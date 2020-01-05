<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\Image;

/**
 *
 */
class ImageRepository extends Repository
{
    protected static $model_name = 'url';

    protected static $order_by_columns = [
        'id' => 'asc',
    ];

    protected static $search_columns = [
        //
    ];

    /**
     * Create a new repository instance.
     *
     * @param \Thtg88\MmCms\Models\Image	$model
     * @return  void
     */
    public function __construct(Image $model)
    {
        $this->model = $model;

        parent::__construct();
    }
}
