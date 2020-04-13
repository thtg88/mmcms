<?php

namespace Thtg88\MmCms\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use InvalidArgumentException;

/**
 * Helper methods for database.
 */
class DatabaseHelper
{
    /**
     * Get a list of all the database table names.
     *
     * @return array
     *
     * @throws \InvalidArgumentException If the database connection is not supported
     */
    public function getTableNames(): array
    {
        // Get the default connection
        $default_database_connection = Config::get('database.default');

        // Get database name from the default connection
        $database_name = Config::get(
            'database.connections.'.$default_database_connection.'.database'
        );

        $supported_database_connections = ['mysql', 'sqlite', 'testbench'];

        if ($default_database_connection === 'mysql') {
            // This returns an array in the following format
            // [
            //  0 => [
            //      'Tables_in_{database_name}' => 'table_name',
            //  ],
            //  ...
            // ]
            $tables = DB::select('SHOW TABLES');

            // We get only the table names from the previous array
            return array_column($tables, 'Tables_in_'.$database_name);
        }

        if (
            $default_database_connection === 'sqlite' ||
            $default_database_connection === 'testbench'
        ) {
            // This returns an array in the following format
            // [
            //  0 => [
            //      'name' => 'table_name',
            //  ],
            //  ...
            // ]
            $tables = DB::select(
                'SELECT name FROM sqlite_master WHERE type =\'table\' '.
                'AND name NOT LIKE \'sqlite_%\';'
            );

            return array_column($tables, 'name');
        }

        throw new InvalidArgumentException(
            'The database connection '.$default_database_connection.' is not '.
            'supported. Please switch to a supported database connection ('.
            implode(', ', $supported_database_connections).')'
        );
    }
}
