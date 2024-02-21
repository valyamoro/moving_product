<?php
declare(strict_types=1);

namespace App\Services;

abstract class BaseService
{
    public function __construct(protected BaseRepository $repository)
    {

    }

}
