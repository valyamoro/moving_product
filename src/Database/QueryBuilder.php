<?php

namespace App\Database;

abstract class QueryBuilder
{
    abstract public function prepare(string $query): self;

    abstract public function execute(array $binds = []): self;

    abstract public function fetch(): array;

    abstract public function fetchAll(): array;

    abstract public function lastInsertId(): int;

    abstract public function rowCount(): int;

}
