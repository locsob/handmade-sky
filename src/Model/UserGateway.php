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

    public function find(int $id): User
    {
        $row = $this->client->find("
            SELECT * FROM users where id = :id
        ", [':id' => $id]);

        return User::populate((int) $row['id'], $row['email'], $row['password']);
    }

    public function update(User $user): void
    {
        $this->client->modify("
            UPDATE users SET `email` = :email, `password` = :password
        ", [':email' => $user->getEmail(), ':password' => $user->getPassHash()]);
    }

    public function insert(User $user): void
    {
        $id = $this->client->modify("
            INSERT INTO users (`email`, `password`) VALUES (:email, :password)
        ", [':email' => $user->getEmail(), ':password' => $user->getPassHash()]);

        $user->setId($id);
    }

    public function findByEmail(string $email): ?User
    {
        $row = $this->client->find("
            SELECT * FROM users where email = :email
        ", [':email' => $email]);

        return User::populate((int) $row['id'], $row['email'], $row['password']);
    }
}
