<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;
use Cancio\Ds\UnionFind\QuickUnion;

class QuickUnionTest extends AbstractUnionFindTestCase
{

    protected function getUnionFindInstance(array $args = []): UnionFindInterface
    {
        return new QuickUnion($args);
    }

    public function testGetAncestorsWithMissingElement(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');

        $this->expectException(ElementNotFoundException::class);

        $quickUnion->getAncestors('C');
    }

    public function testGetAncestorsBeforeUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');

        $this->assertSame([], $quickUnion->getAncestors('A'));
        $this->assertSame([], $quickUnion->getAncestors('B'));
    }

    public function testGetAncestorsAfterUnite(): void
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

        $this->assertSame([], $quickUnion->getAncestors('A'));
        $this->assertSame([], $quickUnion->getAncestors('B'));
        $this->assertSame(['B'], $quickUnion->getAncestors('C'));
        $this->assertSame([], $quickUnion->getAncestors('D'));
        $this->assertSame([], $quickUnion->getAncestors('E'));
        $this->assertSame([], $quickUnion->getAncestors('F'));
        $this->assertSame([], $quickUnion->getAncestors('G'));

        $quickUnion->unite('D', 'F');

        $this->assertSame([], $quickUnion->getAncestors('A'));
        $this->assertSame([], $quickUnion->getAncestors('B'));
        $this->assertSame(['B'], $quickUnion->getAncestors('C'));
        $this->assertSame(['F'], $quickUnion->getAncestors('D'));
        $this->assertSame([], $quickUnion->getAncestors('E'));
        $this->assertSame([], $quickUnion->getAncestors('F'));
        $this->assertSame([], $quickUnion->getAncestors('G'));

        $quickUnion->unite('G', 'E');

        $this->assertSame([], $quickUnion->getAncestors('A'));
        $this->assertSame([], $quickUnion->getAncestors('B'));
        $this->assertSame(['B'], $quickUnion->getAncestors('C'));
        $this->assertSame(['F'], $quickUnion->getAncestors('D'));
        $this->assertSame([], $quickUnion->getAncestors('E'));
        $this->assertSame([], $quickUnion->getAncestors('F'));
        $this->assertSame(['E'], $quickUnion->getAncestors('G'));

        $quickUnion->unite('E', 'F');

        $this->assertSame([], $quickUnion->getAncestors('A'));
        $this->assertSame([], $quickUnion->getAncestors('B'));
        $this->assertSame(['B'], $quickUnion->getAncestors('C'));
        $this->assertSame(['F'], $quickUnion->getAncestors('D'));
        $this->assertSame(['F'], $quickUnion->getAncestors('E'));
        $this->assertSame([], $quickUnion->getAncestors('F'));
        $this->assertSame(['E', 'F'], $quickUnion->getAncestors('G'));
    }

    public function testGetDescendentsWithMissingElement(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');

        $this->expectException(ElementNotFoundException::class);

        $quickUnion->getDescendents('C');
    }

    public function testGetDescendentsBeforeUnite(): void
    {
        $quickUnion = new QuickUnion();

        $quickUnion->add('A');
        $quickUnion->add('B');

        $this->assertSame([], $quickUnion->getDescendents('A'));
        $this->assertSame([], $quickUnion->getDescendents('B'));
    }

    public function testGetDescendentsAfterUnite(): void
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

        $this->assertSame([], $quickUnion->getDescendents('A'));
        $this->assertSame(['C'], $quickUnion->getDescendents('B'));
        $this->assertSame([], $quickUnion->getDescendents('C'));
        $this->assertSame([], $quickUnion->getDescendents('D'));
        $this->assertSame([], $quickUnion->getDescendents('E'));
        $this->assertSame([], $quickUnion->getDescendents('F'));
        $this->assertSame([], $quickUnion->getDescendents('G'));

        $quickUnion->unite('D', 'F');

        $this->assertSame([], $quickUnion->getDescendents('A'));
        $this->assertSame(['C'], $quickUnion->getDescendents('B'));
        $this->assertSame([], $quickUnion->getDescendents('C'));
        $this->assertSame([], $quickUnion->getDescendents('D'));
        $this->assertSame([], $quickUnion->getDescendents('E'));
        $this->assertSame(['D'], $quickUnion->getDescendents('F'));
        $this->assertSame([], $quickUnion->getDescendents('G'));

        $quickUnion->unite('G', 'E');

        $this->assertSame([], $quickUnion->getDescendents('A'));
        $this->assertSame(['C'], $quickUnion->getDescendents('B'));
        $this->assertSame([], $quickUnion->getDescendents('C'));
        $this->assertSame([], $quickUnion->getDescendents('D'));
        $this->assertSame(['G'], $quickUnion->getDescendents('E'));
        $this->assertSame(['D'], $quickUnion->getDescendents('F'));
        $this->assertSame([], $quickUnion->getDescendents('G'));

        $quickUnion->unite('E', 'F');

        $this->assertSame([], $quickUnion->getDescendents('A'));
        $this->assertSame(['C'], $quickUnion->getDescendents('B'));
        $this->assertSame([], $quickUnion->getDescendents('C'));
        $this->assertSame([], $quickUnion->getDescendents('D'));
        $this->assertSame(['G'], $quickUnion->getDescendents('E'));
        $this->assertSame(['D', 'E', 'G'], $quickUnion->getDescendents('F'));
        $this->assertSame([], $quickUnion->getDescendents('G'));
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