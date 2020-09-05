<?php

declare(strict_types=1);

namespace Skytest\Controller;

use Skytest\HttpKernel\Response;

abstract class AbstractController
{
    protected function template(string $templateName, $params = []): Response
    {
        extract($params);

        ob_start();

        $template = ROOT_PATH . "views/$templateName";
        if (file_exists($template)) {
            echo require $template;

            $content = substr(ob_get_contents(), 0, -1);

            ob_end_clean();

            return new Response($content);
        }

        throw new \InvalidArgumentException(sprintf('Template not exists %s', $templateName));
    }

    protected function redirect(string $route)
    {
        return new Response('', 301, [
            'Location' => $route
        ]);
    }
}
