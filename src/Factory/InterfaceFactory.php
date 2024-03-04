<?php
declare(strict_types=1);

namespace App\Factory;

interface InterfaceFactory
{
    public static function create(array $data): object;

}
