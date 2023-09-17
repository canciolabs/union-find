<?php

namespace Cancio\Ds\UnionFind\Tests\Exception;

use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;
use PHPUnit\Framework\TestCase;

class ElementNotFoundExceptionTest extends TestCase
{

    public function testConstructor()
    {
        $e1 = new ElementNotFoundException('A');
        $e2 = new ElementNotFoundException('B');

        $this->assertSame('The element "A" was not found in the union.', $e1->getMessage());
        $this->assertSame('The element "B" was not found in the union.', $e2->getMessage());
    }

}