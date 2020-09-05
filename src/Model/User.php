<?php

declare(strict_types=1);

namespace Skytest\Model;

class User
{
    private string $email;

    private string $passHash;

    private int $id;

    /**
     * User constructor.
     * @param string $email
     * @param string $password
     */
    private function __construct(string $email, string $password)
    {
        $this->email = $email;
        $this->passHash = $password;
    }

    public static function populate(int $id, string $email, string $password)
    {
        $user = new self($email, $password);

        $user->id = $id;
        return $user;
    }

    public static function create(string $email, string $password)
    {
        return new self(
            $email,
            self::hashUserPass($password, $email)
        );
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassHash(): string
    {
        return $this->passHash;
    }

    /**
     * @param string $password
     * @param string $email
     * @return string
     */
    private static function hashUserPass(string $password, string $email): string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['salt' => base64_encode($email)]);

        if (is_string($hash)) {
            return $hash;
        }

        throw new \InvalidArgumentException('Invalid password');
    }

    public function isCorrectPassword(string $password): bool
    {
        return $this->passHash === self::hashUserPass($password, $this->email);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }
}
