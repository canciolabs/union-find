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

}