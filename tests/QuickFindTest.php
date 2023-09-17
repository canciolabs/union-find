<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;
use Cancio\Ds\UnionFind\QuickFind;
use PHPUnit\Framework\TestCase;

class QuickFindTest extends TestCase
{

    public function testGetRootWithMissingElement(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $quickFind->getRoot('C');
    }

    public function testGetRootBeforeUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');

        $this->assertSame('A', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
    }

    public function testGetRootAfterUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');
        $quickFind->add('D');

        // Unite A-B
        $quickFind->unite('A', 'B');
        $this->assertSame('B', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('C', $quickFind->getRoot('C'));
        $this->assertSame('D', $quickFind->getRoot('D'));

        // Unite C-D
        $quickFind->unite('C', 'D');
        $this->assertSame('B', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('D', $quickFind->getRoot('C'));
        $this->assertSame('D', $quickFind->getRoot('D'));

        // Unite A-C
        $quickFind->unite('A', 'C');
        $this->assertSame('D', $quickFind->getRoot('A'));
        $this->assertSame('D', $quickFind->getRoot('B'));
        $this->assertSame('D', $quickFind->getRoot('C'));
        $this->assertSame('D', $quickFind->getRoot('D'));
    }

    public function testRemoveWithMissingElement(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $quickFind->remove('C');
    }

    public function testRemoveBeforeUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');

        $quickFind->remove('A');

        $this->assertFalse($quickFind->has('A'));
        $this->assertTrue($quickFind->has('B'));
    }

    public function testRemoveAAfterUniteAB(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');

        $quickFind->unite('A', 'B');

        $quickFind->remove('A');

        $this->assertFalse($quickFind->has('A'));
        $this->assertTrue($quickFind->has('B'));
        $this->assertTrue($quickFind->has('C'));
    }

    public function testRemoveBAfterUniteAB(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');

        $quickFind->unite('A', 'B');

        $quickFind->remove('B');

        $this->assertFalse($quickFind->has('A'));
        $this->assertFalse($quickFind->has('B'));
        $this->assertTrue($quickFind->has('C'));
    }

}