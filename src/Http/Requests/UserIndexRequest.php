<?php

namespace Thtg88\MmCms\Http\Requests;

class UserIndexRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
