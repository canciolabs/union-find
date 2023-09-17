<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Cancio\Ds\UnionFind\QuickUnion;

class QuickUnionTest extends AbstractUnionFindTestCase
{

    use AncestorsTestTrait;
    use DescendentsTestTrait;

    protected function getUnionFindInstance(array $args = []): UnionFindInterface
    {
        return new QuickUnion($args);
    }

    public function testGetRootAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');
        $quickUnion->add('D');
        $quickUnion->add('E');
        $quickUnion->add('F');
        $quickUnion->add('G');

        $quickUnion->unite('C', 'B');

        $this->assertSame('A', $quickUnion->getRoot('A'));
        $this->assertSame('B', $quickUnion->getRoot('B'));
        $this->assertSame('B', $quickUnion->getRoot('C'));
        $this->assertSame('D', $quickUnion->getRoot('D'));
        $this->assertSame('E', $quickUnion->getRoot('E'));
        $this->assertSame('F', $quickUnion->getRoot('F'));
        $this->assertSame('G', $quickUnion->getRoot('G'));

        $quickUnion->unite('D', 'F');

        $this->assertSame('A', $quickUnion->getRoot('A'));
        $this->assertSame('B', $quickUnion->getRoot('B'));
        $this->assertSame('B', $quickUnion->getRoot('C'));
        $this->assertSame('F', $quickUnion->getRoot('D'));
        $this->assertSame('E', $quickUnion->getRoot('E'));
        $this->assertSame('F', $quickUnion->getRoot('F'));
        $this->assertSame('G', $quickUnion->getRoot('G'));

        $quickUnion->unite('G', 'E');

        $this->assertSame('A', $quickUnion->getRoot('A'));
        $this->assertSame('B', $quickUnion->getRoot('B'));
        $this->assertSame('B', $quickUnion->getRoot('C'));
        $this->assertSame('F', $quickUnion->getRoot('D'));
        $this->assertSame('E', $quickUnion->getRoot('E'));
        $this->assertSame('F', $quickUnion->getRoot('F'));
        $this->assertSame('E', $quickUnion->getRoot('G'));

        $quickUnion->unite('E', 'F');

        $this->assertSame('A', $quickUnion->getRoot('A'));
        $this->assertSame('B', $quickUnion->getRoot('B'));
        $this->assertSame('B', $quickUnion->getRoot('C'));
        $this->assertSame('F', $quickUnion->getRoot('D'));
        $this->assertSame('F', $quickUnion->getRoot('E'));
        $this->assertSame('F', $quickUnion->getRoot('F'));
        $this->assertSame('F', $quickUnion->getRoot('G'));
    }

    public function testRemoveParentAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');

        $quickUnion->unite('A', 'B');

        $quickUnion->remove('B');

        $this->assertFalse($quickUnion->has('A'));
        $this->assertFalse($quickUnion->has('B'));
        $this->assertTrue($quickUnion->has('C'));
    }

    public function testRemoveChildAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');

        $quickUnion->unite('A', 'B');

        $quickUnion->remove('A');

        $this->assertFalse($quickUnion->has('A'));
        $this->assertTrue($quickUnion->has('B'));
        $this->assertTrue($quickUnion->has('C'));
    }

    public function testRemoveRootAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');
        $quickUnion->add('D');
        $quickUnion->add('E');
        $quickUnion->add('F');
        $quickUnion->add('G');

        $quickUnion->unite('C', 'B');
        $quickUnion->unite('D', 'F');
        $quickUnion->unite('G', 'E');
        $quickUnion->unite('E', 'F');

        $quickUnion->remove('F');

        $this->assertTrue($quickUnion->has('A'));
        $this->assertTrue($quickUnion->has('B'));
        $this->assertTrue($quickUnion->has('C'));
        $this->assertFalse($quickUnion->has('D'));
        $this->assertFalse($quickUnion->has('E'));
        $this->assertFalse($quickUnion->has('F'));
        $this->assertFalse($quickUnion->has('G'));
    }

    public function testRemoveInnerNodeAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');
        $quickUnion->add('D');
        $quickUnion->add('E');
        $quickUnion->add('F');
        $quickUnion->add('G');

        $quickUnion->unite('C', 'B');
        $quickUnion->unite('D', 'F');
        $quickUnion->unite('G', 'E');
        $quickUnion->unite('E', 'F');

        $quickUnion->remove('E');

        $this->assertTrue($quickUnion->has('A'));
        $this->assertTrue($quickUnion->has('B'));
        $this->assertTrue($quickUnion->has('C'));
        $this->assertTrue($quickUnion->has('D'));
        $this->assertFalse($quickUnion->has('E'));
        $this->assertTrue($quickUnion->has('F'));
        $this->assertFalse($quickUnion->has('G'));
    }

    public function testRemoveLeafAfterUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');
        $quickUnion->add('C');
        $quickUnion->add('D');
        $quickUnion->add('E');
        $quickUnion->add('F');
        $quickUnion->add('G');

        $quickUnion->unite('C', 'B');
        $quickUnion->unite('D', 'F');
        $quickUnion->unite('G', 'E');
        $quickUnion->unite('E', 'F');

        $quickUnion->remove('G');

        $this->assertTrue($quickUnion->has('A'));
        $this->assertTrue($quickUnion->has('B'));
        $this->assertTrue($quickUnion->has('C'));
        $this->assertTrue($quickUnion->has('D'));
        $this->assertTrue($quickUnion->has('E'));
        $this->assertTrue($quickUnion->has('F'));
        $this->assertFalse($quickUnion->has('G'));
    }

}