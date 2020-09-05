<?php

declare(strict_types=1);

namespace Skytest\Model;

class User
{
    private string $email;

    private string $passHash;

    /**
     * User constructor.
     * @param string $email
     * @param string $password
     */
    public function __construct(string $email, string $password)
    {
        $this->email = $email;
        $hash = password_hash($password, PASSWORD_BCRYPT);

        if (!is_string($hash)) {
            throw new \InvalidArgumentException('Invalid password');
        }
        $this->passHash = $hash;
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
}
