<?php

namespace App\Factory;

use App\Models\Model;

interface InterfaceFactory
{
    public static function create(array $data): Model;
}
