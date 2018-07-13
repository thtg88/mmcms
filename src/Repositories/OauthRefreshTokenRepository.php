<?php

namespace Thtg88\MmCms\Repositories;

use Thtg88\MmCms\Models\OauthRefreshToken;

/**
 *
 */
class OauthRefreshTokenRepository extends Repository
{
	protected static $model_name = 'id';

	protected static $order_by_columns = [
		'user_id' => 'asc',
		'client_id' => 'asc',
		'id' => 'asc',
	];

	protected static $search_columns = [
		//
	];

	/**
	 * Create a new repository instance.
	 *
	 * @param	\Thtg88\MmCms\OauthRefreshToken	$oauth_refresh_token
	 * @return	void
	 */
	public function __construct(OauthRefreshToken $oauth_refresh_token)
	{
		$this->model = $oauth_refresh_token;

		parent::__construct();
	}
}
