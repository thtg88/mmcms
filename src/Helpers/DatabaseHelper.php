<?php

namespace Thtg88\MmCms\Helpers;

/**
 * Helper methods for database.
 */
class DatabaseHelper
{
    /**
     * Get a list of all the database table names.
     *
     * @return  array
     */
    public function getTableNames()
    {
        // This returns an array in the following format
        // [
        //  0 => [
        //      'Tables_in_{database_name}' => 'table_name',
        //  ],
        //  ...
        // ]
        $tables = \DB::select('SHOW TABLES');

        // Get the default connection
		$default_database_connection = config('database.default');

        // Get database name from the default connection
		$database_name = config('database.connections.'.$default_database_connection.'.database');

        // We get only the table names from the previous array
        return array_column($tables, 'Tables_in_'.$database_name);
    }
}
