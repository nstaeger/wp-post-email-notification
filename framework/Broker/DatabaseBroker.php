<?php

namespace Nstaeger\Framework\Broker;

interface DatabaseBroker
{
    /**
     * @param string $table Table name
     * @param array  $where A named array of WHERE clauses (in column => value pairs). Multiple clauses will be joined
     *                      with ANDs. Both $where columns and $where values should be "raw". Sending a null value will
     *                      create an IS NULL comparison - the corresponding format will be ignored in this case.
     * @return int|false The number of rows updated, or false on error.
     */
    function delete($table, array $where);

    /**
     * Perform a MySQL database query.
     *
     * @param string      $query    Query statement with sprintf()-like placeholders
     * @param array|mixed $args     The array of variables to substitute into the query's placeholders if being called like
     *                              {@link http://php.net/vsprintf vsprintf()}, or the first variable to substitute into the query's placeholders if
     *                              being called like {@link http://php.net/sprintf sprintf()}.
     * @param mixed       $args,... further variables to substitute into the query's placeholders if being called like
     *                              {@link http://php.net/sprintf sprintf()}.
     * @return int|false Number of rows affected/selected or false on error
     */
    function executePreparedQuery($query, $args);

    /**
     * Perform a MySQL database query.
     *
     * @param string $query Database query
     * @return int|false Number of rows affected/selected or false on error
     */
    function executeQuery($query);

    /**
     * Executes a SQL query and returns the entire SQL result.
     *
     * @param string $query SQL query.
     * @return array Database query results as associative array.
     */
    function fetchAll($query);

    /**
     * Insert a row into a table.
     *
     * @param string $table Table name
     * @param array  $data  Data to insert (in column => value pairs). Both $data columns and $data values should be
     *                      "raw" (neither should be SQL escaped). Sending a null value will cause the column to be set
     *                      to NULL - the corresponding format is ignored in this case.
     * @return int|false The number of rows inserted, or false on error.
     */
    function insert($table, array $data);
}
