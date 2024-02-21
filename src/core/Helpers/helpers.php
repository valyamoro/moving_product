<?php
declare(strict_types=1);

if (!\function_exists('dump')) {
    function dump(array $value): void
    {
        echo '<pre>';
        print_r($value);
        echo '<pre>';
    }
}

