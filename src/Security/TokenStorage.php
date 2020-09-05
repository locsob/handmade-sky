<?php

declare(strict_types=1);

namespace Skytest\Security;

use Skytest\Model\User;
use Skytest\Model\UserGateway;

class TokenStorage
{
    private UserGateway $userGateway;

    private array $cache = [];

    /**
     * TokenStorage constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function getCurrentUser(): ?User
    {
        $id = $_SESSION['id'];

        if (!$id) {
            return null;
        }

        return $this->userGateway->find($id);
    }

    public function isGuest(): bool
    {
        $id = $_SERVER['id'];

        if (!$id) {
            return true;
        }

        return (bool) $this->userGateway->find($id);
    }

    public function loginUser(User $user): void
    {
        $_SESSION['id'] = $user->getId();
    }

    public function logout()
    {
        session_destroy();
    }
}
