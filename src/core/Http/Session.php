<?php
declare(strict_types=1);

namespace App\core\Http;

final class Session
{
    private array $messages = [];

    public function start(bool $flag): void
    {
        if ($flag) {
            \session_start();
        }
    }

    public function getId(?string $name = null): string
    {
        return \session_id($name);
    }

    public function setId(string $value): void
    {
        \session_id($value);
    }

    public function get(string $key, ?string $name = null): mixed
    {
        if (!\is_null($name)) {
            return $this->exists($key) ? $_SESSION[$key][$name] : null;
        }

        return $this->exists($key) ? $_SESSION[$key] : null;
    }

    public function getFlash(): array
    {
        return $this->messages;
    }

    public function setFlash(array $messages, bool $isSession = false): void
    {
        $this->messages = $messages;

        if ($isSession) {
            $_SESSION = $messages;
        }
    }

    public function delete(string $key): bool
    {
        if ($this->exists($key)) {
            $_SESSION[$key] = null;
            unset($_SESSION[$key]);

            return true;
        }

        return false;
    }

    public function destroy(string $key): bool
    {
        if ($this->exists($key)) {
            \session_unset();
            \session_destroy();

            return true;
        }

        return false;
    }

    public function exists(string $key): bool
    {
        return !empty($_SESSION[$key]);
    }

}
