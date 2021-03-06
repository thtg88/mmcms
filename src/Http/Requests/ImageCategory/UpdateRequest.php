<?php

namespace Thtg88\MmCms\Http\Requests\ImageCategory;

use Illuminate\Validation\Rule;
use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\ImageCategoryRepository;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageCategoryRepository $repository
     * @param \Thtg88\MmCms\Helpers\DatabaseHelper               $database_helper
     *
     * @return void
     */
    public function __construct(
        ImageCategoryRepository $repository,
        DatabaseHelper $database_helper
    ) {
        $this->repository = $repository;
        $this->database_helper = $database_helper;
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
            'sequence'     => 'required|integer|min:1',
            'target_table' => [
                'required',
                'string',
                'in:'.implode(',', $table_names),
            ],
        ];

        // Get input
        $input = $this->all();

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        // Now we get the "most recent" target_table and name,
        // either if it comes from the input, or from the resource
        // And we perform the unique-ness check on the name within the target_table

        if (
            array_key_exists('target_table', $input)
            && !empty($input['target_table'])
            && is_string($input['target_table'])
        ) {
            $target_table = $input['target_table'];
        } else {
            $target_table = $this->resource->target_table;
        }

        if (
            array_key_exists('name', $input)
            && !empty($input['name'])
            && is_string($input['name'])
        ) {
            $name = $input['name'];
        } else {
            $name = $this->resource->name;
        }

        if (
            (
                array_key_exists('name', $input)
                && !empty($input['name'])
                && is_string($input['name'])
                && !empty($target_table)
                && is_string($target_table)
            )
            || (
                array_key_exists('target_table', $input)
                && !empty($input['target_table'])
                && is_string($input['target_table'])
                && !empty($name)
                && is_string($name)
            )
        ) {
            $rules['name'][] = Rule::unique($this->repository->getModelTable())
                ->where(static function ($query) use ($target_table) {
                    $query->whereNull('deleted_at')
                        ->where('target_table', $target_table);
                });
        }

        return $rules;
    }
}
