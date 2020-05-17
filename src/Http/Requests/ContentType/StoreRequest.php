<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentType;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentType::class;

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
        return [
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
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'priority' => [
                'required',
                'integer',
                'min:1',
            ],
        ];
    }
}
