<?php

declare(strict_types=1);

namespace Skytest\Controller;

use http\Exception\InvalidArgumentException;
use Skytest\HttpKernel\Response;

class AbstractController
{
    protected function template(string $templateName, $params = []): Response
    {
        extract($params);

        ob_start();

        $template = ROOT_PATH . "views/$templateName";
        if (file_exists($template)) {
            echo require $template;

            $content = ob_get_contents();

            ob_end_clean();

            return new Response($content);
        }

        throw new \InvalidArgumentException(sprintf('Template not exists %s', $templateName));
    }
}
