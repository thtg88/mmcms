<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Http\Requests\StoreRequest as BaseStoreRequest;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class StoreRequest extends BaseStoreRequest
{
    /**
     * Create a new request instance.
     *
     * @param	\Thtg88\MmCms\Repositories\ImageCategoryRepository	$repository
     * @param	\Thtg88\MmCms\Helpers\DatabaseHelper	$database_helper
     * @return	void
     */
    public function __construct(ImageCategoryRepository $repository, DatabaseHelper $database_helper)
    {
        $this->repository = $repository;
        $this->database_helper = $database_helper;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Get all tables
        $table_names = $this->database_helper->getTableNames();

        // Get input
        $input = $this->all();

        $all_rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'sequence' => 'required|integer|min:1',
            'target_table' => [
                'required',
                'string',
                'in:'.implode(',', $table_names),
            ],
        ];

        if (
            array_key_exists('name', $input)
            && array_key_exists('target_table', $input)
            && !empty($input['name'])
            && !empty($input['target_table'])
            && is_string($input['name'])
            && is_string($input['target_table'])
        ) {
            $all_rules['name'][] = Rule::unique($this->repository->getName(), 'name')
                ->where(function ($query) use ($input) {
                    $query->whereNull('deleted_at')
                        ->where('target_table', $input['target_table']);
                });
        }

        return $all_rules;
    }
}
