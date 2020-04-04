<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\Rules\Exists;

/**
 * Validate the existence of an attribute value in a case-insensitive way,
 * in a database table.
 */
class ExistsCaseInsensitive extends Exists
{
    use ValidatesAttributes;

    /**
     * Validate the existence of an attribute value in a case-insensitive way,
     * in a database table.
     *
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @return bool
     */
    public function passes($attribute, $value, array $parameters): bool
    {
        if (! is_string($value)) {
            return false;
        }

        $this->requireParameterCount(
            1,
            $parameters,
            'mmcms::exists_case_insensitive'
        );

        [$connection, $table] = $this->parseTable($parameters[0]);

        // The second parameter position holds the name of the column that should be
        // verified as existing. If this parameter is not specified we will guess
        // that the columns being "verified" shares the given attribute's name.
        $column = $this->getQueryColumn($parameters, $attribute);

        $expected = is_array($value) ? count(array_unique($value)) : 1;

        return $this->getExistCount(
            $connection,
            $table,
            DB::raw('LOWER('.$column.')'),
            strtolower($value),
            $parameters
        ) >= $expected;
    }

    /**
     * Convert the rule to a validation string.
     *
     * @return string
     */
    public function __toString()
    {
        return rtrim(sprintf(
            'exists_case_insensitive:%s,%s,%s',
            $this->table,
            $this->column,
            $this->formatWheres()
        ), ',');
    }
}
