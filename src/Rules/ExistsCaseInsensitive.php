<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Concerns\ValidatesAttributes;
use Illuminate\Validation\Rules\Exists;

/**
 * Validate the existence of an attribute value in a case-insensitive way,
 * in a database table.
 *
 * If a database column is not specified, the attribute will be used.
 *
 */
class ExistsCaseInsensitive extends Exists implements Rule
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
     * Validate the existence of an attribute value in a case-insensitive way,
     * in a database table.
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
            'mmcms::exists_case_insensitive'
        );

        [$connection, $table] = $this->parseTable($this->table);

        // The second parameter position holds the name of the column that should be
        // verified as existing. If this parameter is not specified we will guess
        // that the columns being "verified" shares the given attribute's name.
        $column = $this->getQueryColumn($parameters, $attribute);

        $expected = is_array($value) ? count(array_unique($value)) : 1;

        $verifier = app('validation.presence');

        $extra = array_merge(
            $this->getExtraConditions(
                array_values(array_slice($parameters, 2))
            ),
            $this->queryCallbacks()
        );

        // Make both column and value the same casing
        $column = DB::raw('LOWER('.$column.')');

        return is_array($value) ?
            $verifier->getMultiCount(
                $table,
                $column,
                $value,
                $extra
            ) :
            $verifier->getCount(
                $table,
                $column,
                strtolower($value),
                null,
                null,
                $extra
            );
    }

    public function message(): string
    {
        return __('mmcms::validation.exists_case_insensitive', [
             'attribute' => str_replace('_', ' ', Str::snake($this->attribute)),
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
            'mmcms::exists_case_insensitive:%s,%s,%s',
            $this->table,
            $this->column,
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
        ];

        if ($formatted_wheres !== '') {
            $parameters[] = $formatted_wheres;
        }

        return $parameters;
    }
}
