<?php

namespace Thtg88\MmCms\Http\Requests\ContentField;

use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Models\ContentField;
use Thtg88\MmCms\Repositories\ContentFieldRepository;
use Thtg88\MmCms\Repositories\ContentModelRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;
use Thtg88\MmCms\Rules\Rule;

class StoreRequest extends BaseStoreRequest
{
    /** @var string */
    protected $model_classname = ContentField::class;

    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentFieldRepository $repository
     * @param \Thtg88\MmCms\Repositories\ContentModelRepository $content_models
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $content_types
     * @return void
     */
    public function __construct(
        ContentFieldRepository $repository,
        ContentModelRepository $content_models,
        ContentTypeRepository $content_types
    ) {
        $this->repository = $repository;
        $this->content_models = $content_models;
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
            'content_model_id' => [
                'required',
                'integer',
                Rule::exists($this->content_models->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'content_type_id' => [
                'required',
                'integer',
                Rule::exists($this->content_types->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'display_name' => [
                'required',
                'string',
                'max:255',
            ],
            'helper_text' => [
                'nullable',
                'string',
            ],
            'is_resource_name' => [
                'required',
                'boolean',
            ],
            'is_mandatory' => [
                'required',
                'boolean',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ];

        if (
            $this->content_model_id !== null &&
            ! empty($this->content_model_id) &&
            is_numeric($this->content_model_id)
        ) {
            // Add unique-ness of fields within model
            $all_rules['display_name'] = Rule::uniqueCaseInsensitive(
                $this->repository->getModelTable()
            )->where(function ($query) {
                $query->whereNull('deleted_at')
                    ->where('content_model_id', $this->content_model_id);
            });
            $all_rules['name'] = Rule::uniqueCaseInsensitive(
                $this->repository->getModelTable()
            )->where(function ($query) {
                $query->whereNull('deleted_at')
                    ->where('content_model_id', $this->content_model_id);
            });
        }

        return $all_rules;
    }
}
