<?php

declare(strict_types=1);

namespace Skytest\Db;

use SQLite3;
use SQLite3Stmt;

class SqliteClient
{
    private SQLite3 $db;

    /**
     * SqliteClient constructor.
     * @param string $dbPath
     */
    public function __construct(string $dbPath)
    {
        $this->db = new SQLite3($dbPath);
    }

    public function __destruct()
    {
        $this->db->close();
    }

    /**
     * @param string $query
     * @param array $params
     * @return int|false
     */
    public function modify(string $query, $params = []): int
    {
        $stmt = $this->db->prepare($query);
        $stmt = $this->bindParams($params, $stmt);

        $stmt->execute();

        return $this->db->lastInsertRowID();
    }

    /**
     * @param string $query
     * @param array $params
     * @return false|array
     */
    public function find(string $query, $params = []): ?array
    {
        $stmt = $this->db->prepare($query);
        $stmt = $this->bindParams($params, $stmt);

        $res = $stmt->execute();

        return $res->fetchArray(SQLITE3_ASSOC) ?: null;
    }

    public function findAll(string $query, $params = []): array
    {
        $stmt = $this->db->prepare($query);
        $stmt = $this->bindParams($params, $stmt);

        $res = $stmt->execute();

        return $res->fetchArray();
    }

    /**
     * @param array $params
     * @param SQLite3Stmt $stmt
     * @return SQLite3Stmt
     */
    private function bindParams(array $params, SQLite3Stmt $stmt): SQLite3Stmt
    {
        foreach ($params as $name => $value) {
            $stmt->bindValue($name, $value);
        }
        return $stmt;
    }
}
