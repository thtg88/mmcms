<?php

namespace Thtg88\MmCms\Http\Requests\ContentModel;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentModel;
use Thtg88\MmCms\Repositories\ContentModelRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentModel::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentModelRepository $repository
     *
     * @return void
     */
    public function __construct(ContentModelRepository $repository)
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
            'base_route_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'description' => [
                'nullable',
                'string',
            ],
            'model_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(static function ($query) {
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
            'table_name' => [
                'nullable',
                'string',
                'max:255',
                Rule::uniqueCaseInsensitive($this->repository->getModelTable())
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
        ];
    }
}
