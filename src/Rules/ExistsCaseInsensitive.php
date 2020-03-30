<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Validation\Rules\Exists;

class ExistsCaseInsensitive extends Exists
{
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
