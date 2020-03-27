<?php

namespace Thtg88\MmCms\Http\Requests\SeoEntry;

use Thtg88\MmCms\Http\Requests\Request;
use Thtg88\MmCms\Repositories\SeoEntryRepository;

class RestoreSeoEntryRequest extends Request
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
        return $this->authorizeResourceDeletedExist();
    }
}
