<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Response;
use Skytest\HttpKernel\Response\RedirectResponse;
use Skytest\Security\TokenStorage;

abstract class AbstractController
{
    protected TokenStorage $tokenStorage;

    /**
     * AbstractController constructor.
     * @param TokenStorage $tokenStorage
     */
    public function __construct(TokenStorage $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    protected function template(string $templateName, $params = []): Response
    {
        extract($params);

        ob_start();

        $template = ROOT_PATH . "views/$templateName";
        if (file_exists($template)) {
            $csrf = null;
            if (!$this->tokenStorage->isGuest()) {
                $csrf = $this->tokenStorage->getCsrfToken();
            }

            echo require $template;

            $content = substr(ob_get_contents(), 0, -1);

            ob_end_clean();

            return new Response($content);
        }

        throw new \InvalidArgumentException(sprintf('Template not exists %s', $templateName));
    }

    protected function redirect(string $route, $params = [])
    {
        return new RedirectResponse($route, $params);
    }
}
