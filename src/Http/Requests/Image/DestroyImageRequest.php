<?php

namespace App\Http\Requests\Image;

// Requests
use SdSomersetDesign\CastleCombe\Http\Requests\DestroyRequest;
// Repositories
use SdSomersetDesign\CastleCombe\Repositories\ImageRepository;

class DestroyImageRequest extends DestroyRequest
{
    /**
	 * Create a new request instance.
	 *
	 * @param	\SdSomersetDesign\CastleCombe\Repositories\ImageRepository	$repository
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
