<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\ImageCategory;

/**
 *
 */
class ImageCategoryRepository extends Repository
{
	protected static $model_name = 'name';

	protected static $order_by_columns = [
		'target_table' => 'asc',
		'sequence' => 'asc',
		'name' => 'asc',
	];

	protected static $search_columns = [
		'name',
		'target_table',
	];

	/**
	 * Create a new repository instance.
	 *
	 * @param \Thtg88\MmCms\Models\ImageCategory	$model
	 * @return  void
	 */
	public function __construct(ImageCategory $model)
	{
		$this->model = $model;

		parent::__construct();
	}
}
