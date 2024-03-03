<?php
declare(strict_types=1);

namespace App\Services\Contracts;

use App\Models\Model;

interface RepositoryInterface
{
    // никакие другие методы не добавляем.
    public function getById(int $id): array;
}
