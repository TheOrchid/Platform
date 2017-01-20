<?php

namespace Orchid\Schema;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

/**
 * Class BaseSchema.
 */
abstract class BaseSchema
{
    /**
     * Database instance.
     *
     * @var
     */
    public $database;

    /**
     * Connection name.
     *
     * @var
     */
    public $connection;

    /**
     * @var array
     */
    protected $schema = [];

    /**
     * BaseSchema constructor.
     */
    public function __construct()
    {
        $this->connection = DB::connection()->getName();
        $this->setConnection($this->connection);
    }

    /**
     * Set connection.
     *
     * @param $connection
     *
     * @return $this
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
        $this->database = DB::connection($this->connection);

        return $this;
    }

    /**
     * Fetch database name.
     *
     * @return mixed
     */
    public function getDatabaseName()
    {
        return $this->database->getDatabaseName();
    }

    /**
     * Get table total row count.
     *
     * @param $table
     *
     * @return mixed
     */
    public function getTableRowCount($table)
    {
        return $this->database->table($table)->count();
    }

    /**
     * Perform raw sql query.
     *
     * @param $query
     *
     * @return mixed
     */
    public function rawQuery($query)
    {
        return $this->database->select(DB::raw($query));
    }

    /**
     * Fetch data form table using pagination.
     *
     * @param $tableName
     * @param int    $page
     * @param int    $limit
     * @param null   $orderAttribute
     * @param string $order
     *
     * @return mixed
     */
    public function getPaginatedData($tableName, $page = 1, $limit = 15, $orderAttribute = null, $order = 'DESC')
    {
        Paginator::currentPageResolver(function () use ($page) {
            return $page;
        });
        $data = $this->database->table($tableName);
        if (null === $orderAttribute) {
            return $data->paginate($limit);
        }

        return $data->orderBy($orderAttribute, $order)->paginate($limit);
    }
}
