<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Cancio\Ds\UnionFind\QuickFind;

class QuickFindTest extends AbstractUnionFindTestCase
{

    protected function getUnionFindInstance(array $args = []): UnionFindInterface
    {
        return new QuickFind($args);
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