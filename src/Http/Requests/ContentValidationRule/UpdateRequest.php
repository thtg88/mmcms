<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $repository
     *
     * @return void
     */
    public function __construct(ContentValidationRuleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable())
                    ->where(function ($query) {
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
