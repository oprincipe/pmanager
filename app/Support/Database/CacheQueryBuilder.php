<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 04/04/18
 * Time: 17:49
 */

namespace App\Support\Database;


trait CacheQueryBuilder
{
    /**
     * Get a new query builder instance for the connection.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function newBaseQueryBuilder()
    {
        $conn = $this->getConnection();

        $grammar = $conn->getQueryGrammar();

        return new Builder($conn, $grammar, $conn->getPostProcessor());
    }
}