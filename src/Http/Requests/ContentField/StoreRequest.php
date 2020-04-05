<?php

namespace Thtg88\MmCms\Http\Requests\ContentField;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Repositories\ContentFieldRepository;
use Thtg88\MmCms\Repositories\ContentModelRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class StoreRequest extends BaseStoreRequest
{
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
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->authorizeDeveloper();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get input
        $input = $this->all();

        $all_rules = [
            'content_model_id' => [
                'required',
                'integer',
                Rule::exists($this->repository->getModelTable(), 'id')
                    ->where(static function ($query) {
                        $query->whereNull('deleted_at');
                    }),
            ],
            'content_type_id' => [
                'required',
                'integer',
                Rule::exists($this->repository->getModelTable(), 'id')
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
            'name' => [
                'required',
                'string',
                'max:255',
            ],
        ];

        if (
            array_key_exists('content_model_id', $input) &&
            !empty($input['content_model_id']) &&
            is_numeric($input['content_model_id'])
        ) {
            // Add unique-ness of fields within model
            $input['display_name'] = Rule::unique(
                $this->repository->getModelTable()
            )->where(static function ($query) {
                $query->whereNull('deleted_at')
                    ->where('content_model_id', $input['content_model_id']);
            });
            $input['name'] = Rule::unique($this->repository->getModelTable())
                ->where(static function ($query) {
                    $query->whereNull('deleted_at')
                        ->where('content_model_id', $input['content_model_id']);
                });
        }

        return $all_rules;
    }
}
