<?php
declare(strict_types=1);

namespace App\Factory;

use App\Models\Storage;

class StorageFactory implements InterfaceFactory
{
    public static function create(array $data): Storage
    {
        return new Storage(
            $data['name'],
            $data['created_at'],
            $data['updated_at'],
        );
    }
}
