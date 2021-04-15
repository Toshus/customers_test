<?php

declare(strict_types=1);

namespace App\Tests\unit;

use PHPUnit\Framework\TestCase;

class UnitCommon extends TestCase
{
    protected function createMockObject(string $class)
    {
        return $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->getMock();
    }
}