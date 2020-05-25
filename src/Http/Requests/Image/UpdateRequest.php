<?php

namespace Thtg88\MmCms\Http\Requests\Image;

use Thtg88\MmCms\Helpers\DatabaseHelper;
use Thtg88\MmCms\Http\Requests\UpdateRequest as BaseUpdateRequest;
use Thtg88\MmCms\Repositories\ImageRepository;
use Thtg88\MmCms\Rules\Rule;

class UpdateRequest extends BaseUpdateRequest
{
    /**
     * Create a new request instance.
     *
     * @param \Thtg88\MmCms\Repositories\ImageRepository $repository
     * @param \Thtg88\MmCms\Helpers\DatabaseHelper $database_helper
     * @return void
     */
    public function __construct(ImageRepository $repository, DatabaseHelper $database_helper)
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
        return $this->authorizeResourceExist();
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

        // Get resource id
        $resource_id = $this->route('id');

        // Get resource
        $resource = $this->repository->find($resource_id, false, true);

        // Get all tables
        $table_names = $this->database_helper->getTableNames();

        // We define the real table name in order to check if the target exists
        $real_table_name = null;

        // First we check if the provided input contains a table name
        if (array_key_exists('target_table', $input) && in_array($input['target_table'], $table_names, true)) {
            // If so, this is the table name we are going to use for our validation
            $real_table_name = $input['target_table'];
        } else {
            // Otherwise use the existing table name
            $real_table_name = $resource->target_table;
        }

        $all_rules = [
            'caption' => 'nullable|string',
            'name' => 'nullable|string|max:255',
            'target_id' => [
                'required',
                'integer',
            ],
            'target_table' => [
                'nullable',
                'string',
                'in:'.implode(',', $table_names),
            ],
            'title' => 'nullable|string|max:255',
        ];

        // Get necessary rules based on input (same keys basically)
        $rules = array_intersect_key($all_rules, $input);

        if (
            in_array($real_table_name, $table_names, true)
            && (
                array_key_exists('target_id', $input)
                || array_key_exists('target_table', $input)
            )
        ) {
            // If it's in the list of tables, we want to check it's a valid id in that table
            $rules['target_id'][] = Rule::existsWithoutSoftDeleted(
                $real_table_name,
                'id'
            );
        }

        return $rules;
    }
}
