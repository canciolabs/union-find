<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;

trait AncestorsTestTrait
{

    public function testGetAncestorsWithMissingElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $unionFind->getAncestors('C');
    }

    public function testGetAncestorsBeforeUnite(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->assertSame([], $unionFind->getAncestors('A'));
        $this->assertSame([], $unionFind->getAncestors('B'));
    }

    public function testGetAncestorsAfterUnite(): void
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

        $this->assertSame([], $unionFind->getAncestors('A'));
        $this->assertSame([], $unionFind->getAncestors('B'));
        $this->assertSame(['B'], $unionFind->getAncestors('C'));
        $this->assertSame([], $unionFind->getAncestors('D'));
        $this->assertSame([], $unionFind->getAncestors('E'));
        $this->assertSame([], $unionFind->getAncestors('F'));
        $this->assertSame([], $unionFind->getAncestors('G'));

        $unionFind->unite('D', 'F');

        $this->assertSame([], $unionFind->getAncestors('A'));
        $this->assertSame([], $unionFind->getAncestors('B'));
        $this->assertSame(['B'], $unionFind->getAncestors('C'));
        $this->assertSame(['F'], $unionFind->getAncestors('D'));
        $this->assertSame([], $unionFind->getAncestors('E'));
        $this->assertSame([], $unionFind->getAncestors('F'));
        $this->assertSame([], $unionFind->getAncestors('G'));

        $unionFind->unite('G', 'E');

        $this->assertSame([], $unionFind->getAncestors('A'));
        $this->assertSame([], $unionFind->getAncestors('B'));
        $this->assertSame(['B'], $unionFind->getAncestors('C'));
        $this->assertSame(['F'], $unionFind->getAncestors('D'));
        $this->assertSame([], $unionFind->getAncestors('E'));
        $this->assertSame([], $unionFind->getAncestors('F'));
        $this->assertSame(['E'], $unionFind->getAncestors('G'));

        $unionFind->unite('E', 'F');

        $this->assertSame([], $unionFind->getAncestors('A'));
        $this->assertSame([], $unionFind->getAncestors('B'));
        $this->assertSame(['B'], $unionFind->getAncestors('C'));
        $this->assertSame(['F'], $unionFind->getAncestors('D'));
        $this->assertSame(['F'], $unionFind->getAncestors('E'));
        $this->assertSame([], $unionFind->getAncestors('F'));
        $this->assertSame(['E', 'F'], $unionFind->getAncestors('G'));
    }

}