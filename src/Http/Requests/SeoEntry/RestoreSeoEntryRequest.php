<?php

namespace App\Http\Requests\SeoEntry;

// Requests
use SdSomersetDesign\CastleCombe\Http\Requests\Request;
// Repositories
use SdSomersetDesign\CastleCombe\Repositories\SeoEntryRepository;

class RestoreSeoEntryRequest extends Request
{
	/**
	 * Create a new request instance.
	 *
	 * @param	\SdSomersetDesign\CastleCombe\Repositories\SeoEntryRepository	$repository
	 * @return	void
	 */
	public function __construct(SeoEntryRepository $repository)
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
