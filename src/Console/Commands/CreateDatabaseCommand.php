<?php

namespace Thtg88\MmCms\Console\Commands;

use Illuminate\Config\Repository as Config;
use Illuminate\Console\Command;
use PDO;
use Symfony\Component\Console\Input\InputArgument;

class CreateDatabaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:create {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the database if it does not exists.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws RuntimeException If database connection not "mysql" nor "pgsql".
     */
    public function handle()
    {
        // Get default database connection from config
        $default_database_connection = Config::get('database.default');

        // Get database name from arguments
        $database_name = $this->argument('name');

        if ($default_database_connection === 'pgsql') {
            $this->info('Creating PostgreSQL database '.$database_name.' ...');

            $created = $this->createPostgreSql($database_name);

            if ($created === true) {
                $this->info('PostgreSQL database '.$database_name.' created!');
            } else {
                $this->info(
                    'PostgreSQL database '.
                    $database_name.
                    ' already exists. Skipping...'
                );
            }
        }

        if ($default_database_connection === 'mysql') {
            $this->info('Creating MySQL database '.$database_name.' ...');

            $created = $this->createMySql($database_name);

            if ($created === true) {
                $this->info('MySQL database '.$database_name.' created!');
            } else {
                $this->info(
                    'MySQL database '.
                    $database_name.
                    ' failed creating. Skipping...'
                );
            }
        }

        if (! isset($created)) {
            throw new \RuntimeException(
                'Database type not supported: '.
                $default_database_connection
            );
        }
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the database'],
        ];
    }

    /**
     * Create a PostgreSQL database.
     *
     * @param string $database_name
     * @return mixed
     */
    protected function createPostgreSql($database_name)
    {
        // We reset default database name to "postgres"
        // as we can not create the database we can not connect to yet :\
        Config::set('database.connections.pgsql.database', 'postgres');

        // Get databases names
        $databases = array_map(
            static function ($database) {
                return $database->datname;
            },
            \DB::select('SELECT datname FROM pg_database')
        );

        if (array_search($database_name, $databases) === false) {
            \DB::statement('CREATE DATABASE '.$database_name.';');
            return true;
        }

        return false;
    }

    /**
     * Create a MySQL database.
     *
     * @param string $database_name
     * @return mixed
     */
    protected function createMySql($database_name)
    {
        $pdo = $this->getPDOConnection(
            Config::get('database.connections.mysql.host'),
            Config::get('database.connections.mysql.port'),
            Config::get('database.connections.mysql.username'),
            Config::get('database.connections.mysql.password')
        );

        $pdo->exec(
            'CREATE DATABASE IF NOT EXISTS '.$database_name.
            ' CHARACTER SET '.Config::get('database.connections.mysql.charset').
            ' COLLATE '.Config::get('database.connections.mysql.collation').';'
        );

        return true;
    }

    /**
     * Return a new MySQL PDO connection from a given host, port, username,
     * and password.
     *
     * @param string $host
     * @param int $port
     * @param string $username
     * @param string $password
     * @return PDO
     */
    protected function getPDOConnection($host, $port, $username, $password)
    {
        return new PDO(
            'mysql:host='.$host.';port='.$port.';',
            $username,
            $password
        );
    }
}
