<?php
declare(strict_types=1);

namespace App\Factory;

use App\Models\Model;

class Product implements InterfaceFactory
{
    public static function create(array $data): Model
    {
    }
}
