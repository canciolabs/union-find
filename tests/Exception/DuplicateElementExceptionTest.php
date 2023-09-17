<?php

namespace Cancio\Ds\UnionFind\Tests\Exception;

use Cancio\Ds\UnionFind\Exception\DuplicateElementException;
use PHPUnit\Framework\TestCase;

class DuplicateElementExceptionTest extends TestCase
{

    public function testConstructor()
    {
        $e1 = new DuplicateElementException('A');
        $e2 = new DuplicateElementException('B');

        $this->assertSame('The element "A" was already added to the union.', $e1->getMessage());
        $this->assertSame('The element "B" was already added to the union.', $e2->getMessage());
    }

}