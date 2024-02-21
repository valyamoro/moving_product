<?php
declare(strict_types=1);

namespace App\Database;

class PDODriver
{
    private ?\PDOStatement $sth;

    public function __construct(
        private readonly \PDO $dbh,
    ) {}

    public function prepare(string $query): self
    {
        $this->sth = $this->dbh->prepare($query);

        return $this;
    }

    public function execute(array $binds = []): self
    {
        $this->sth->execute($binds);

        return $this;
    }

    public function fetch(): array
    {
        $result = $this->sth->fetch();
        $this->sth = null;

        return $result !== false ? $result : [];
    }

    public function fetchAll(): array
    {
        $result = $this->sth->fetchAll();
        $this->sth = null;

        return $result !== false ? $result : [];
    }

    public function lastInsertId(): int
    {
        return (int)$this->dbh->lastInsertId();
    }

    public function rowCount(): int
    {
        $result = $this->sth->rowCount();
        $this->sth = null;

        return $result;
    }

    public function beginTransaction(): void
    {
        $this->dbh->beginTransaction();
    }

    public function commit(): void
    {
        $this->dbh->commit();
    }

    public function rollBack(): void
    {
        $this->dbh->rollBack();
    }

}
