<?php
declare(strict_types=1);

namespace App\core\Http;

final class Request
{
    public function isMethod(?string $method = null): bool
    {
        return $_SERVER['REQUEST_METHOD'] === \strtoupper($method);
    }

    public function getMethod(?string $name = null): mixed
    {
        return !$this->isEmpty($name) ? $_REQUEST[$name] ?? null : $_REQUEST;
    }

    public function isEmpty(mixed $name): bool
    {
        return !isset($name);
    }

}
