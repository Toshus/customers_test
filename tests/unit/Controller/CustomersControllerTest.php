<?php

declare(strict_types=1);

namespace App\Tests\Unit\Controller;

use PHPUnit\Framework\TestCase;

class CustomersControllerTest extends TestCase
{
    public function testGetCustomers()
    {
        $a = 1;
        $b = 1;
        $this->assertSame($a, $b);
    }
}
