<?php
declare(strict_types=1);

namespace App\core\Http;

final class Response
{
    public function set(int $code): bool
    {
        return (bool)\http_response_code($code);
    }

    public function get(): int
    {
        $code = \http_response_code();
        return $code !== false ? $code : 0;
    }

}