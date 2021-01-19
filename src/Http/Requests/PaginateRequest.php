<?php

namespace Thtg88\MmCms\Http\Requests;

use Thtg88\MmCms\Http\Requests\Contracts\PaginateRequestInterface;

class PaginateRequest extends Request implements PaginateRequestInterface
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('viewAny', $this->model_classname);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'filters'                      => 'nullable|array',
            'filters.*.name'               => 'required|string|min:2|max:255',
            'filters.*.operator'           => 'required|string|in:=,<>,>,<,<=,>=,like,in,between',
            'filters.*.relationship-field' => 'nullable|string',
            'filters.*.target_type'        => 'nullable|string',
            'filters.*.value'              => 'nullable|string',
            'page'                         => 'nullable|integer|min:1',
            'page_size'                    => 'nullable|integer|min:2',
            'q'                            => 'nullable|string|max:255',
            'recovery'                     => 'nullable|boolean',
            'sort_name'                    => 'required_with:sort_direction|string|min:2|max:255',
            'sort_direction'               => 'required_with:sort_name|string|in:asc,desc',
        ];
    }
}
