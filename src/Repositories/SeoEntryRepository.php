<?php

namespace SdSomersetDesign\CastleCombe\Repositories;

use SdSomersetDesign\CastleCombe\Models\SeoEntry;

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
	 * @param \SdSomersetDesign\CastleCombe\Models\SeoEntry	$model
	 * @return  void
	 */
	public function __construct(SeoEntry $model)
	{
		$this->model = $model;

		parent::__construct();
	}
}
