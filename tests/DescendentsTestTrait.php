<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;

trait DescendentsTestTrait
{

    public function testGetDescendentsWithMissingElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $unionFind->getDescendents('C');
    }

    public function testGetDescendentsBeforeUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->assertSame([], $unionFind->getDescendents('A'));
        $this->assertSame([], $unionFind->getDescendents('B'));
    }

    public function testGetDescendentsAfterUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');
        $unionFind->add('D');
        $unionFind->add('E');
        $unionFind->add('F');
        $unionFind->add('G');

        $unionFind->unite('C', 'B');

        $this->assertSame([], $unionFind->getDescendents('A'));
        $this->assertSame(['C'], $unionFind->getDescendents('B'));
        $this->assertSame([], $unionFind->getDescendents('C'));
        $this->assertSame([], $unionFind->getDescendents('D'));
        $this->assertSame([], $unionFind->getDescendents('E'));
        $this->assertSame([], $unionFind->getDescendents('F'));
        $this->assertSame([], $unionFind->getDescendents('G'));

        $unionFind->unite('D', 'F');

        $this->assertSame([], $unionFind->getDescendents('A'));
        $this->assertSame(['C'], $unionFind->getDescendents('B'));
        $this->assertSame([], $unionFind->getDescendents('C'));
        $this->assertSame([], $unionFind->getDescendents('D'));
        $this->assertSame([], $unionFind->getDescendents('E'));
        $this->assertSame(['D'], $unionFind->getDescendents('F'));
        $this->assertSame([], $unionFind->getDescendents('G'));

        $unionFind->unite('G', 'E');

        $this->assertSame([], $unionFind->getDescendents('A'));
        $this->assertSame(['C'], $unionFind->getDescendents('B'));
        $this->assertSame([], $unionFind->getDescendents('C'));
        $this->assertSame([], $unionFind->getDescendents('D'));
        $this->assertSame(['G'], $unionFind->getDescendents('E'));
        $this->assertSame(['D'], $unionFind->getDescendents('F'));
        $this->assertSame([], $unionFind->getDescendents('G'));

        $unionFind->unite('E', 'F');

        $this->assertSame([], $unionFind->getDescendents('A'));
        $this->assertSame(['C'], $unionFind->getDescendents('B'));
        $this->assertSame([], $unionFind->getDescendents('C'));
        $this->assertSame([], $unionFind->getDescendents('D'));
        $this->assertSame(['G'], $unionFind->getDescendents('E'));
        $this->assertSame(['D', 'E', 'G'], $unionFind->getDescendents('F'));
        $this->assertSame([], $unionFind->getDescendents('G'));
    }

}