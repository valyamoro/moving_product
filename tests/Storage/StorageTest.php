<?php

namespace Storage;

use PHPUnit\Framework\TestCase;

class StorageTest extends TestCase
{
    public function testCreateNewStorage(): void
    {
        $data = [
            'id' => 1,
            'name' => 'storage1',
            'createdAt' => '04-03-2024',
            'updatedAt' => '04-03-2024',
        ];
        $storage = \App\Factory\Storage::create($data);

        $this->assertInstanceOf(\App\Models\Storage::class, $storage);

        $this->assertSame(1, $storage->getId());
        $this->assertSame('storage1', $storage->getTitle());
        $this->assertSame('04-03-2024', $storage->getCreatedAt());
        $this->assertSame('04-03-2024', $storage->getUpdatedAt());
    }

}
