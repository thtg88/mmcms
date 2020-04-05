<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ContentTypeRepository $repository
     * @param \Thtg88\MmCms\Repositories\ContentMigrationMethodRepository $content_migration_methods
     * @return void
     */
    public function __construct(ContentTypeRepository $repository, ContentMigrationMethodRepository $content_migration_methods)
    {
        $this->repository = $repository;

        $this->content_migration_methods = $content_migration_methods;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'description' => [
                'nullable',
                'string',
            ],
            'content_migration_method_id' => [
                'nullable',
                'integer',
                Rule::exists($this->repository->getModelTable(), 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getModelTable(), 'name')->where(function ($query) {
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
