<?php

namespace Xand\Component\Database;

/**
 * Interface ConnectionInterface
 *
 * @author Sasha Broslavskiy <sasha.broslavskiy@gmail.com>
 */
interface ConnectionInterface
{
    /**
     * @return \PDO
     */
    public function getPdo();

    /**
     * @param string $sql
     * @param array  $args
     *
     * @return \PDOStatement
     */
    public function executeNativeQuery($sql, array $args = []);

    /**
     * @return array
     */
    public function getQueryStack();

    /**
     * @param string $pattern
     *
     * @return array
     */
    public function grep($pattern);
}