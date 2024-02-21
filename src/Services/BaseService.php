<?php
declare(strict_types=1);

namespace App\Services;

class BaseService
{
    public function __construct(protected BaseRepository $repository)
    {

    }

}
