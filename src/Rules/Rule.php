<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Validation\Rule as BaseRule;

class Rule extends BaseRule
{
    /**
     * Get a exists case insensitive constraint builder instance.
     *
     * @param string $table
     * @param string $column
     * @return \Thtg88\MmCms\Rules\ExistsCaseInsensitive
     */
    public static function existsCaseInsensitive(
        string $table,
        string $column = 'NULL'
    ): ExistsCaseInsensitive {
        return new ExistsCaseInsensitive($table, $column);
    }

    /**
     * Get a unique case insensitive constraint builder instance.
     *
     * @param string $table
     * @param string $column
     * @return \Thtg88\MmCms\Rules\UniqueCaseInsensitive
     */
    public static function uniqueCaseInsensitive(
        string $table,
        string $column = 'NULL'
    ): UniqueCaseInsensitive {
        return new UniqueCaseInsensitive($table, $column);
    }
}
