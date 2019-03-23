<?php

namespace SdSomersetDesign\CastleCombe\Repositories;

use SdSomersetDesign\CastleCombe\Models\Image;

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
	 * @param \SdSomersetDesign\CastleCombe\Models\Image	$model
	 * @return  void
	 */
	public function __construct(Image $model)
	{
		$this->model = $model;

		parent::__construct();
	}
}
