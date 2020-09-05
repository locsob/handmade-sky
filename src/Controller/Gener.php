<?php

declare(strict_types=1);

namespace Skytest\Controller;

class Gener
{
    public function get()
    {
        return rand(10, 1000);
    }
}
