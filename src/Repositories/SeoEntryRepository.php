<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\SeoEntry;

/**
 *
 */
class SeoEntryRepository extends Repository
{
	protected static $model_name = 'name';

	protected static $order_by_columns = [
		'id' => 'asc',
	];

	protected static $search_columns = [
		//
	];

	/**
	 * Create a new repository instance.
	 *
	 * @param \Thtg88\MmCms\Models\SeoEntry	$model
	 * @return  void
	 */
	public function __construct(SeoEntry $model)
	{
		$this->model = $model;

		parent::__construct();
	}
}
