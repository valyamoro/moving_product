<?php
declare(strict_types=1);

namespace App\Databases;

interface DatabaseConnection
{
    public function connection(): object;
}
