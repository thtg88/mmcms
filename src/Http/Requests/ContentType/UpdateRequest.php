<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;
use Thtg88\MmCms\Rules\Rule;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $repository
     * @param \Thtg88\MmCms\Repositories\ContentMigrationMethodRepository $content_migration_methods
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $content_validation_rules
     * @return void
     */
    public function __construct(
        ContentTypeRepository $repository,
        ContentMigrationMethodRepository $content_migration_methods,
        ContentValidationRuleRepository $content_validation_rules
    ) {
        $this->repository = $repository;

        $this->content_migration_methods = $content_migration_methods;
        $this->content_validation_rules = $content_validation_rules;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
            'description' => [
                'nullable',
                'string',
            ],
            'content_migration_method_id' => [
                'nullable',
                'integer',
                Rule::exists(
                    $this->content_migration_methods->getModelTable(),
                    'id'
                )->where(static function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'content_validation_rule_id' => [
                'nullable',
                'integer',
                Rule::exists(
                    $this->content_validation_rules->getModelTable(),
                    'id'
                )->where(static function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(function ($query) {
                        $query->whereNull('deleted_at')
                            ->where('id', '<>', $this->route('id'));
                    }),
            ],
            'priority' => [
                'required',
                'integer',
                'min:1',
            ],
        ];

        // Get input
        $input = $this->all();

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        return $rules;
    }
}
