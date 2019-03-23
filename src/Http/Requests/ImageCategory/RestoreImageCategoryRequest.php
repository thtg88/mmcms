<?php

namespace App\Http\Requests\ImageCategory;

// Requests
use SdSomersetDesign\CastleCombe\Http\Requests\Request;
// Repositories
use SdSomersetDesign\CastleCombe\Repositories\ImageCategoryRepository;

class RestoreImageCategoryRequest extends Request
{
	/**
	 * Create a new request instance.
	 *
	 * @param	\SdSomersetDesign\CastleCombe\Repositories\ImageCategoryRepository	$repository
	 * @return	void
	 */
	public function __construct(ImageCategoryRepository $repository)
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
        return $this->authorizeResourceDeletedExist();
    }
}
