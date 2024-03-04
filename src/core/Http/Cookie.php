<?php
declare(strict_types=1);

namespace App\core\Http;

final class Cookie
{
    public function set(string $name, string $value): bool
    {
        return \setcookie($name, $value);
    }

    public function get(string $name = ''): mixed
    {
        return empty($name) ? $_COOKIE : $_COOKIE[$name];
    }

}
