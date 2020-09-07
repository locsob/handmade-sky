<?php

declare(strict_types=1);

namespace Skytest\Security;

use Skytest\Model\User;
use Skytest\Model\UserGateway;

class TokenStorage
{
    private UserGateway $userGateway;

    /**
     * TokenStorage constructor.
     * @param UserGateway $userGateway
     */
    public function __construct(UserGateway $userGateway)
    {
        $this->userGateway = $userGateway;
    }

    public function findCurrentUser(): ?User
    {
        $id = $_SESSION['id'];

        if (!$id) {
            return null;
        }

        return $this->userGateway->find($id);
    }

    public function getCurrentUser(): User
    {
        if ($user = $this->findCurrentUser()) {
            return $user;
        }

        throw new \DomainException('User must be logged in');
    }


    public function isGuest(): bool
    {
        $id = $_SESSION['id'];

        if (!$id) {
            return true;
        }

        return (bool) !$this->userGateway->find($id);
    }

    public function loginUser(User $user): void
    {
        $_SESSION['id'] = $user->getId();
        $_SESSION['csrf'] = $this->generateCsrfToken($user);
    }

    public function logout()
    {
        session_destroy();
    }

    public function getCsrfToken(): ?string
    {
        return $_SESSION['csrf'];
    }

    /**
     * @param User $user
     * @return string
     */
    private function generateCsrfToken(User $user): string
    {
        return rand(555, 999999) . base64_encode(json_encode($user->getName()));
    }
}
