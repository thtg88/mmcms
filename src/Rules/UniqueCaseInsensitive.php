<?php

namespace Thtg88\MmCms\Rules;

use Illuminate\Validation\Rules\Unique;

class UniqueCaseInsensitive extends Unique
{
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
}
