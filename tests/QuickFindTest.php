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
        $quickFind->add('E');
        $quickFind->add('F');
        $quickFind->add('G');

        $quickFind->unite('C', 'B');

        $this->assertSame('A', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('B', $quickFind->getRoot('C'));
        $this->assertSame('D', $quickFind->getRoot('D'));
        $this->assertSame('E', $quickFind->getRoot('E'));
        $this->assertSame('F', $quickFind->getRoot('F'));
        $this->assertSame('G', $quickFind->getRoot('G'));

        $quickFind->unite('D', 'F');

        $this->assertSame('A', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('B', $quickFind->getRoot('C'));
        $this->assertSame('F', $quickFind->getRoot('D'));
        $this->assertSame('E', $quickFind->getRoot('E'));
        $this->assertSame('F', $quickFind->getRoot('F'));
        $this->assertSame('G', $quickFind->getRoot('G'));

        $quickFind->unite('G', 'E');

        $this->assertSame('A', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('B', $quickFind->getRoot('C'));
        $this->assertSame('F', $quickFind->getRoot('D'));
        $this->assertSame('E', $quickFind->getRoot('E'));
        $this->assertSame('F', $quickFind->getRoot('F'));
        $this->assertSame('E', $quickFind->getRoot('G'));

        $quickFind->unite('E', 'F');

        $this->assertSame('A', $quickFind->getRoot('A'));
        $this->assertSame('B', $quickFind->getRoot('B'));
        $this->assertSame('B', $quickFind->getRoot('C'));
        $this->assertSame('F', $quickFind->getRoot('D'));
        $this->assertSame('F', $quickFind->getRoot('E'));
        $this->assertSame('F', $quickFind->getRoot('F'));
        $this->assertSame('F', $quickFind->getRoot('G'));
    }

    public function testRemoveRootAfterUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');
        $quickFind->add('D');
        $quickFind->add('E');
        $quickFind->add('F');
        $quickFind->add('G');

        $quickFind->unite('C', 'B');
        $quickFind->unite('D', 'F');
        $quickFind->unite('G', 'E');
        $quickFind->unite('E', 'F');

        $quickFind->remove('F');

        $this->assertTrue($quickFind->has('A'));
        $this->assertTrue($quickFind->has('B'));
        $this->assertTrue($quickFind->has('C'));
        $this->assertFalse($quickFind->has('D'));
        $this->assertFalse($quickFind->has('E'));
        $this->assertFalse($quickFind->has('F'));
        $this->assertFalse($quickFind->has('G'));
    }

    public function testRemoveInnerNodeAfterUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');
        $quickFind->add('D');
        $quickFind->add('E');
        $quickFind->add('F');
        $quickFind->add('G');

        $quickFind->unite('C', 'B');
        $quickFind->unite('D', 'F');
        $quickFind->unite('G', 'E');
        $quickFind->unite('E', 'F');

        $quickFind->remove('E');

        $this->assertTrue($quickFind->has('A'));
        $this->assertTrue($quickFind->has('B'));
        $this->assertTrue($quickFind->has('C'));
        $this->assertTrue($quickFind->has('D'));
        $this->assertFalse($quickFind->has('E'));
        $this->assertTrue($quickFind->has('F'));
        $this->assertTrue($quickFind->has('G'));
    }

    public function testRemoveLeafAfterUnite(): void
    {
        $quickFind = new QuickFind();

        $quickFind->add('A');
        $quickFind->add('B');
        $quickFind->add('C');
        $quickFind->add('D');
        $quickFind->add('E');
        $quickFind->add('F');
        $quickFind->add('G');

        $quickFind->unite('C', 'B');
        $quickFind->unite('D', 'F');
        $quickFind->unite('G', 'E');
        $quickFind->unite('E', 'F');

        $quickFind->remove('G');

        $this->assertTrue($quickFind->has('A'));
        $this->assertTrue($quickFind->has('B'));
        $this->assertTrue($quickFind->has('C'));
        $this->assertTrue($quickFind->has('D'));
        $this->assertTrue($quickFind->has('E'));
        $this->assertTrue($quickFind->has('F'));
        $this->assertFalse($quickFind->has('G'));
    }

}