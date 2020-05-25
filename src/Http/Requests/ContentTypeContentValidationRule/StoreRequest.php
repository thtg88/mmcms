<?php

namespace Thtg88\MmCms\Http\Requests\ContentTypeContentValidationRule;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentTypeContentValidationRule;
use Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentTypeContentValidationRule::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeContentValidationRuleRepository $repository
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $content_types
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $content_validation_rules
     * @return void
     */
    public function __construct(
        ContentTypeContentValidationRuleRepository $repository,
        ContentTypeRepository $content_types,
        ContentValidationRuleRepository $content_validation_rules
    ) {
        $this->repository = $repository;
        $this->content_validation_rules = $content_validation_rules;
        $this->content_types = $content_types;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $all_rules = [
            'content_type_id' => [
                'required',
                'integer',
                Rule::existsWithoutSoftDeleted(
                    $this->content_types->getModelTable(),
                    'id'
                ),
            ],
            'content_validation_rule_id' => [
                'required',
                'integer',
                Rule::existsWithoutSoftDeleted(
                    $this->content_validation_rules->getModelTable(),
                    'id'
                ),
            ],
        ];

        if (
            $this->content_type_id !== null &&
            filter_var($this->content_type_id, FILTER_VALIDATE_INT) !== false
        ) {
            $all_rules['content_validation_rule_id'] = Rule::unique(
                $this->repository->getModelTable()
            )->where(function ($query) {
                $query->whereNull('deleted_at')
                    ->where('content_type_id', $this->content_type_id);
            });
        }

        return $all_rules;
    }
}
