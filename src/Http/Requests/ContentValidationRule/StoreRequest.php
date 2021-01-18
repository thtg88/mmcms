<?php

namespace Thtg88\MmCms\Http\Requests\ContentValidationRule;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentValidationRule;
use Thtg88\MmCms\Repositories\ContentValidationRuleRepository;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentValidationRule::class;

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
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable())
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
        ];
    }
}
