<?php

namespace Thtg88\MmCms\Http\Requests;

use Thtg88\MmCms\Http\Requests\Contracts\UpdateRequestInterface;

class UpdateRequest extends Request implements UpdateRequestInterface
{
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
