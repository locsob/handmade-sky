<?php

declare(strict_types=1);

namespace Skytest\Service;

class ValidateService
{
    /**
     * @param array> $rules
     * @return string|null
     */
    public function validate(array $rules): ?string
    {
        foreach ($rules as [$ruleFn, $message]) {
            if ($ruleFn()) {
                return $message;
            }
        }

        return null;
    }
}
