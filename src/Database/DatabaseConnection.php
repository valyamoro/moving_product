<?php
declare(strict_types=1);

namespace App\Database;

interface DatabaseConnection
{
    public function connection();
}