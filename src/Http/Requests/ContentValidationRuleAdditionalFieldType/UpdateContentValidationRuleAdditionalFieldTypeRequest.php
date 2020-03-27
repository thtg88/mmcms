<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRuleAdditionalFieldType;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\UpdateRequest;
use Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository;

class UpdateContentValidationRuleAdditionalFieldTypeRequest extends UpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ContentValidationRuleAdditionalFieldTypeRepository	$repository
     * @return	void
     */
    public function __construct(ContentValidationRuleAdditionalFieldTypeRepository $repository)
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
        if ($this->authorizeDeveloper() === false) {
            return false;
        }

        return $this->authorizeResourceExist();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
            'display_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getName(), 'display_name')->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('id', '<>', $this->route('id'));
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getName(), 'name')->where(function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('id', '<>', $this->route('id'));
                }),
            ],
        ];

        // Get input
        $input = $this->all();

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        return $rules;
    }
}
