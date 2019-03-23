<?php

namespace Thtg88\MmCms\Http\Requests\Image;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\ImageRepository;

class DestroyImageRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\Thtg88\MmCms\Repositories\ImageRepository	$repository
	 * @return	void
	 */
	public function __construct(ImageRepository $repository)
	{
		$this->repository = $repository;
	}

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorizeResourceExist();
    }
}
