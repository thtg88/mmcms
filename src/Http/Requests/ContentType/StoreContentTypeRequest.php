<?php

namespace Thtg88\MmCms\Http\Requests\ContentType;

use Illuminate\Validation\Rule;
// Requests
use Thtg88\MmCms\Http\Requests\StoreRequest;
// Repositories
use Thtg88\MmCms\Repositories\ContentMigrationMethodRepository;
use Thtg88\MmCms\Repositories\ContentTypeRepository;

class StoreContentTypeRequest extends StoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ContentTypeRepository	$repository
     * @param	\Thtg88\MmCms\Repositories\ContentMigrationMethodRepository	$content_migration_methods
     * @return	void
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
        return $this->authorizeDeveloper();
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
                Rule::exists($this->content_migration_methods->getName(), 'id')->where(function ($query) {
                    $query->whereNull('deleted_at');
                }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique($this->repository->getName(), 'name')->where(function ($query) {
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
