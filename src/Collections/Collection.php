<?php
declare(strict_types=1);

namespace App\Collections;

use App\Models\Model;

abstract class Collection
{
    abstract public function makeOne(): Model;
    // Массив коллекций
    abstract public function make(): array;
}
