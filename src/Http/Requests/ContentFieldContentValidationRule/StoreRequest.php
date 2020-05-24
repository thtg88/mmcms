<?php

namespace Thtg88\MmCms\Http\Requests\ContentFieldContentValidationRule;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentFieldContentValidationRule;
use Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository;
use Thtg88\MmCms\Repositories\ContentFieldRepository;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentFieldContentValidationRule::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldContentValidationRuleRepository $repository
     * @param \Thtg88\MmCms\Repositories\ContentFieldRepository $content_fields
     * @param \Thtg88\MmCms\Repositories\ContentValidationRuleRepository $content_validation_rules
     * @return void
     */
    public function __construct(
        ContentFieldContentValidationRuleRepository $repository,
        ContentFieldRepository $content_fields,
        ContentValidationRuleRepository $content_validation_rules
    ) {
        $this->repository = $repository;
        $this->content_fields = $content_fields;
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
            'content_field_id' => [
                'required',
                'integer',
                Rule::exists($this->content_fields->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'content_validation_rule_id' => [
                'required',
                'integer',
                Rule::exists($this->content_validation_rules->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
        ];

        if (
            $this->content_field_id !== null &&
            filter_var($this->content_field_id, FILTER_VALIDATE_INT) !== false
        ) {
            $all_rules['content_validation_rule_id'] = Rule::unique(
                $this->repository->getModelTable()
            )->where(function ($query) {
                $query->whereNull('deleted_at')
                    ->where('content_field_id', $this->content_field_id);
            });
        }

        return $all_rules;
    }
}
