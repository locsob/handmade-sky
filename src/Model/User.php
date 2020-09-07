<?php

declare(strict_types=1);

namespace Skytest\Model;

class User
{
    private string $name;

    private string $passHash;

    private int $id;

    private bool $activated;

    private ?string $activation_code;

    /**
     * User constructor.
     * @param string $name
     * @param string $password
     */
    private function __construct(string $name, string $password)
    {
        $this->name = $name;
        $this->passHash = $password;
    }

    public static function populate(
        int $id,
        string $name,
        string $password,
        bool $activated,
        ?string $activationCode
    ) {
        $user = new self($name, $password);

        $user->id = $id;
        $user->activation_code = $activationCode;
        $user->activated = $activated;

        return $user;
    }

    public static function create(string $name, string $password)
    {
        $user = new self($name, self::hashUserPass($password, $name));
        $user->activated = false;
        $user->activation_code = $user->generateActivationCode();

        return $user;
    }

    public function activate(string $code): void
    {
        if ($this->activation_code === $code) {
            $this->activated = true;
        }
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
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
     * @param string $name
     * @return string
     */
    private static function hashUserPass(string $password, string $name): string
    {
        $hash = password_hash($password, PASSWORD_BCRYPT, ['salt' => base64_encode($name . $name . 19210392131)]);

        if (is_string($hash)) {
            return $hash;
        }

        throw new \InvalidArgumentException('Invalid password');
    }

    public function isCorrectPassword(string $password): bool
    {
        return $this->passHash === self::hashUserPass($password, $this->name);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    private function generateActivationCode(): string
    {
        return (string) password_hash($this->name, PASSWORD_BCRYPT, ['salt' => base64_encode($this->passHash . '59019124318')]);
    }

    public function getActivationCode(): ?string
    {
        return $this->activation_code;
    }

    public function isActivated(): bool
    {
        return $this->activated;
    }

    public function changeCredentials(string $name, string $password): void
    {
        $this->passHash = self::hashUserPass($password, $name);
        $this->name = $name;
    }
}
