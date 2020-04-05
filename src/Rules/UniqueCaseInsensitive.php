<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\Rules\Unique;

/**
 * Validate the uniqueness of an attribute value in a case-insesitive way,
 * on a given database table.
 *
 * If a database column is not specified, the attribute will be used.
 *
 */
class UniqueCaseInsensitive extends Unique implements Rule
{
    use ValidatesAttributes;

    /**
     * The attribute under validation.
     *
     * @var string
     */
    protected $attribute;

    /** @var array */
    protected $implicitAttributes = [];

    /**
     * Validate the uniqueness of an attribute value in a case-insesitive way,
     * on a given database table.
     *
     * If a database column is not specified, the attribute will be used.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $this->attribute = $attribute;

        if (! is_string($value)) {
            return false;
        }

        $parameters = $this->getParameters();

        $this->requireParameterCount(
            1,
            $parameters,
            'mmcms::unique_case_insensitive'
        );

        [$connection, $table] = $this->parseTable($this->table);

        // The second parameter position holds the name of the column that needs to
        // be verified as unique. If this parameter isn't specified we will just
        // assume that this column to be verified shares the attribute's name.
        $column = $this->getQueryColumn($parameters, $attribute);

        [$idColumn, $id] = [null, null];

        if (isset($this->ignore)) {
            [$idColumn, $id] = $this->getUniqueIds($parameters);

            if (! is_null($id)) {
                $id = stripslashes($id);
            }
        }

        $extra = array_merge(
            $this->getUniqueExtra($parameters),
            $this->queryCallbacks()
        );

        // The presence verifier is responsible for counting rows within this store
        // mechanism which might be a relational database or any other permanent
        // data store like Redis, etc. We will use it to determine uniqueness.
        return app('validation.presence')->getCount(
            $table,
            // Make both column and value the same casing
            DB::raw('LOWER('.$column.')'),
            strtolower($value),
            $id,
            $idColumn,
            $extra
        ) == 0;
    }

    public function message(): string
    {
        return __('mmcms::validation.unique_case_insensitive', [
             'attribute' => $this->attribute,
         ]);
    }

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString()
    {
        return rtrim(sprintf(
            'mmcms::unique_case_insensitive:%s,%s,%s,%s,%s',
            $this->table,
            $this->column,
            $this->ignore ? '"'.addslashes($this->ignore).'"' : 'NULL',
            $this->idColumn,
            $this->formatWheres()
        ), ',');
    }

    /**
     * Return the validation rule parameters.
     *
     * @return array
     */
    protected function getParameters(): array
    {
        $formatted_wheres = $this->formatWheres();

        $parameters = [
            $this->table,
            $this->column,
            $this->ignore ? '"'.addslashes($this->ignore).'"' : 'NULL',
            $this->idColumn,
        ];

        if ($formatted_wheres !== '') {
            $parameters[] = $formatted_wheres;
        }

        return $parameters;
    }
}
