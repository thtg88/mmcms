<?php

namespace Thtg88\MmCms\Http\Requests;

use Thtg88\MmCms\Http\Requests\Contracts\DestroyRequestInterface;

class DestroyRequest extends Request implements DestroyRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->authorizeResourceExist() === false) {
            return false;
        }

        return $this->user()->can('delete', $this->resource);
    }
}
