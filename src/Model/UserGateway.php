<?php

declare(strict_types=1);

namespace Skytest\Model;

use Skytest\Db\SqliteClient;

class UserGateway
{
    private SqliteClient $client;

    /**
     * UserGateway constructor.
     * @param SqliteClient $client
     */
    public function __construct(SqliteClient $client)
    {
        $this->client = $client;
    }

    public function find(int $id): ?User
    {
        $row = $this->client->find("
            SELECT * FROM users where id = :id
        ", [':id' => $id]);

        if (!$row) {
            return null;
        }

        return $this->fromFullRow($row);
    }

    public function update(User $user): void
    {
        $this->client->modify("
            UPDATE users SET 
               `name` = :name,
               `password` = :password,
               `activated` = :activated,
               `activation_code` = :activation_code
            WHERE id = :id
        ", array_merge($this->getAllParams($user), [':id' => $user->getId()]));
    }

    public function insert(User $user): void
    {
        $id = $this->client->modify("
            INSERT INTO users (`name`, `password`, `activated`, `activation_code`) 
            VALUES (:name, :password, :activated, :activation_code)
        ", $this->getAllParams($user));

        $user->setId($id);
    }

    public function findByName(string $name): ?User
    {
        $row = $this->client->find("
            SELECT * FROM users where name = :name
        ", [':name' => $name]);

        if (!$row) {
            return null;
        }

        return $this->fromFullRow($row);
    }

    public function findActivated(int $id): ?User
    {
        $row = $this->client->find("
            SELECT * FROM users WHERE id = :id AND `activated` = 1
        ", [':id' => $id]);

        if (!$row) {
            return null;
        }

        return $this->fromFullRow($row);
    }

    /**
     * @param array $row
     * @return User
     */
    private function fromFullRow(array $row): User
    {
        return User::populate((int)$row['id'], $row['name'], $row['password'], (bool) $row['activated'], $row['activation_code']);
    }

    public function findByActivationCode(string $code): ?User
    {
        $row = $this->client->find("
            SELECT * FROM users WHERE `activation_code` = :code
        ", [':code' => $code]);

        if (!$row) {
            return null;
        }

        return $this->fromFullRow($row);
    }

    /**
     * @param User $user
     * @return array
     */
    private function getAllParams(User $user): array
    {
        return [
            ':name' => $user->getName(),
            ':password' => $user->getPassHash(),
            ':activated' => $user->isActivated(),
            ':activation_code' => $user->getActivationCode()
        ];
    }
}
