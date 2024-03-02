<?php
declare(strict_types=1);

namespace App\Factory;

use App\Models\Product;

class ProductFactory implements InterfaceFactory
{
    public static function create(array $data): Product
    {
        return new Product(
            $data['title'],
            (int)$data['price'],
            (int)$data['quantity'],
            $data['created_at'],
            $data['updated_at'],
        );
    }
}
