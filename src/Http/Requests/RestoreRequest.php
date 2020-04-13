<?php

namespace Thtg88\MmCms\Http\Requests;

use Thtg88\MmCms\Http\Requests\Contracts\RestoreRequestInterface;

class RestoreRequest extends Request implements RestoreRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->authorizeResourceDeletedExist() === false) {
            return false;
        }

        return $this->user()->can('restore', $this->resource);
    }
}
