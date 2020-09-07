<?php

declare(strict_types=1);

namespace Skytest\Service;

use Skytest\Security\TokenStorage;

class EmailActivationService
{
    private TokenStorage $tokenStorage;

    /**
     * EmailActivationService constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function send(string $email, string $domain): void
    {
        $user = $this->tokenStorage->getCurrentUser();

        $activationCode = $user->getActivationCode();

        $to      = $email;
        $subject = 'skytest activation';
        $message = sprintf('Go to link for: <a href="http://%s/activate?code=%s">Activate</a>', $domain, $activationCode);
        $headers = 'From: skytest@example.com' . "\r\n" .
            'Reply-To: skytest@example.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }
}
