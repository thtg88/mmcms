<?php

namespace Thtg88\MmCms\Validators;

use Thtg88\MmCms\Rules\UniqueCaseInsensitive;
use Illuminate\Validation\Validator;

class CustomValidator extends Validator
{
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
    public function validateUniqueCaseInsensitive(
        $attribute,
        $value,
        $parameters
    ) {
        if (! is_string($value)) {
            return false;
        }

        $this->requireParameterCount(1, $parameters, 'unique_case_insensitive');

        [$connection, $table] = $this->parseTable($parameters[0]);

        // The second parameter position holds the name of the column that needs to
        // be verified as unique. If this parameter isn't specified we will just
        // assume that this column to be verified shares the attribute's name.
        $column = $this->getQueryColumn($parameters, $attribute);

        [$idColumn, $id] = [null, null];

        if (isset($parameters[2])) {
            [$idColumn, $id] = $this->getUniqueIds($parameters);

            if (! is_null($id)) {
                $id = stripslashes($id);
            }
        }

        // The presence verifier is responsible for counting rows within this store
        // mechanism which might be a relational database or any other permanent
        // data store like Redis, etc. We will use it to determine uniqueness.
        $verifier = $this->getPresenceVerifierFor($connection);

        $extra = $this->getUniqueExtra($parameters);

        if ($this->currentRule instanceof UniqueCaseInsensitive) {
            $extra = array_merge($extra, $this->currentRule->queryCallbacks());
        }

        // Make both column and value the same casing
        return $verifier->getCount(
            $table,
            \DB::raw('LOWER('.$column.')'),
            strtolower($value),
            $id,
            $idColumn,
            $extra
        ) == 0;
    }
}
