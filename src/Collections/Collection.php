<?php
declare(strict_types=1);

namespace App\Collections;

use App\Models\Model;

abstract class Collection
{
    public array $collection;
    abstract public function makeItem(array $data): Model;
    abstract public function makeItems(array $data): array;
    abstract public function update(): array;
    abstract public function remove(): array;

}
