<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentModelRepository;

class DestroyContentModelRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ContentModelRepository	$repository
	 * @return	void
	 */
	public function __construct(ContentModelRepository $repository)
	{
		$this->repository = $repository;
	}
}