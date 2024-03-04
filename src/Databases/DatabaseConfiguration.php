<?php
declare(strict_types=1);

namespace App\Databases;

final class DatabaseConfiguration
{
    public function __construct(
        private readonly string $port,
        private readonly string $host,
        private readonly string $dbname,
        private readonly string $username,
        private readonly string $password,
        private readonly string $charset,
        private readonly array $options = [],
    ) {
    }

    public function getPort(): string
    {
        return $this->port;
    }

    public function getHost(): string
    {
        return $this->host;
    }

    public function getDbname(): string
    {
        return $this->dbname;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCharset(): string
    {
        return $this->charset;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

}
