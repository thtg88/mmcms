<?php

namespace Thtg88\MmCms\Http\Requests\ContentMigrationMethod;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;

class DestroyContentMigrationMethodRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ContentMigrationMethodRepository	$repository
	 * @return	void
	 */
	public function __construct(ContentMigrationMethodRepository $repository)
	{
		$this->repository = $repository;
	}
}