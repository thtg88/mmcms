<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

// Requests
use Thtg88\MmCms\Http\Requests\DestroyRequest;
// Repositories
use Thtg88\MmCms\Repositories\SeoEntryRepository;

class DestroySeoEntryRequest extends DestroyRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\SeoEntryRepository	$repository
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
        return $this->authorizeResourceExist();
    }
}
