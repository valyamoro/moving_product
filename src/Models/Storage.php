<?php
declare(strict_types=1);

namespace App\Models;

use App\core\Model;

class Storage extends Model
{
    private bool $isAdd;
    private string $fromTitle;
    private string $toTitle;

    public function __construct(
        private readonly int $fromId,
        private readonly int $toId,

    ) {
    }

    public function getToTitle(): string
    {
        return $this->toTitle;
    }

    public function getFromTitle(): string
    {
        return $this->fromTitle;
    }

    public function getFromId(): int
    {
        return $this->fromId;
    }

    public function getToId(): int
    {
        return $this->toId;
    }

    public function getIsAdd(): bool
    {
        return $this->isAdd;
    }

    public function setIsAdd(bool $value): void
    {
        $this->isAdd = $value;
    }

    public function setToTitle(string $value): void
    {
        $this->toTitle = $value;
    }

    public function setFromTitle(string $value): void
    {
        $this->fromTitle = $value;
    }

}
