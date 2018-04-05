<?php
/**
 * Created by PhpStorm.
 * User: oprincipe
 * Date: 04/04/18
 * Time: 17:44
 */

namespace App\Support\Database;

use Cache;
use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder extends QueryBuilder
{
    /**
     * Run the query as a "select" statement against the connection.
     *
     * @return array
     */
    protected function runSelect()
    {
        return Cache::store('file')->remember($this->getCacheKey(), 1, function() {
            return parent::runSelect();
        });
    }

    /**
     * Returns a Unique String that can identify this Query.
     *
     * @return string
     */
    protected function getCacheKey()
    {
        return json_encode([
            $this->toSql() => $this->getBindings()
        ]);
    }
}