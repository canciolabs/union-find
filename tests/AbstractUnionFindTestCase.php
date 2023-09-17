<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;
use PHPUnit\Framework\TestCase;

abstract class AbstractUnionFindTestCase extends TestCase
{

    abstract protected function getUnionFindInstance(array $args = []): UnionFindInterface;

    public function testGetRootWithMissingElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $unionFind->getRoot('C');
    }

    public function testGetRootBeforeUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->assertSame('A', $unionFind->getRoot('A'));
        $this->assertSame('B', $unionFind->getRoot('B'));
    }

    abstract public function testGetRootAfterUnite(): void;

    public function testRemoveWithMissingElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $unionFind->remove('C');
    }

    public function testRemoveBeforeUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $unionFind->remove('A');

        $this->assertFalse($unionFind->has('A'));
        $this->assertTrue($unionFind->has('B'));
    }

    public function testRemoveParentAfterUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');

        $unionFind->unite('A', 'B');

        $unionFind->remove('B');

        $this->assertFalse($unionFind->has('A'));
        $this->assertFalse($unionFind->has('B'));
        $this->assertTrue($unionFind->has('C'));
    }

    public function testRemoveChildAfterUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');

        $unionFind->unite('A', 'B');

        $unionFind->remove('A');

        $this->assertFalse($unionFind->has('A'));
        $this->assertTrue($unionFind->has('B'));
        $this->assertTrue($unionFind->has('C'));
    }

    abstract public function testRemoveRootAfterUnite(): void;

    abstract public function testRemoveInnerNodeAfterUnite(): void;

    abstract public function testRemoveLeafAfterUnite(): void;

}