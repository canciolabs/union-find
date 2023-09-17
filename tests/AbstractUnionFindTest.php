<?php

namespace Cancio\Ds\UnionFind\Tests;

use Cancio\Ds\UnionFind\AbstractUnionFind;
use Cancio\Ds\UnionFind\Exception\DuplicateElementException;
use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;
use PHPUnit\Framework\TestCase;

class AbstractUnionFindTest extends TestCase
{

    public function testEmptyConstructor(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $this->assertCount(0, $unionFind);
    }

    public function testConstructorWithElements(): void
    {
        $unionFind = $this->getUnionFindInstance(['A', 'B', 'C']);

        $this->assertCount(3, $unionFind);

        $this->assertTrue($unionFind->has('A'));
        $this->assertTrue($unionFind->has('B'));
        $this->assertTrue($unionFind->has('C'));
        $this->assertFalse($unionFind->has('D'));
    }

    public function testConstructorWithDuplicateElement(): void
    {
        $this->expectException(DuplicateElementException::class);

        $this->getUnionFindInstance(['A', 'A', 'C']);
    }

    public function testAddAndHas(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $this->assertFalse($unionFind->has('A'));
        $this->assertFalse($unionFind->has('B'));

        $unionFind->add('A');

        $this->assertTrue($unionFind->has('A'));
        $this->assertFalse($unionFind->has('B'));
    }

    public function testAddWithDuplicateElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');

        $this->expectException(DuplicateElementException::class);

        $unionFind->add('A');
    }

    public function testAll(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');

        $this->assertSame(['A', 'B', 'C'], $unionFind->all());
    }

    public function testAreConnectedWithMissingElement(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');

        $this->expectException(ElementNotFoundException::class);

        $unionFind->areConnected('A', 'C');
    }

    public function testClear(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');

        $this->assertCount(3, $unionFind);

        $unionFind->clear();

        $this->assertCount(0, $unionFind);
    }

    public function testCopy(): void
    {
        $unionFind = $this->getUnionFindInstance();

        $unionFind->add('A');
        $unionFind->add('B');
        $unionFind->add('C');

        $unionFindCopy = $unionFind->copy();

        $this->assertNotSame($unionFind, $unionFindCopy);
        $this->assertSame(['A' => 'A', 'B' => 'B', 'C' => 'C'], $unionFindCopy->toArray());
    }

    public function testCount(): void
    {
        $unionFind = $this->getUnionFindInstance();
        $this->assertCount(0, $unionFind);

        $unionFind->add('A');
        $this->assertCount(1, $unionFind);

        $unionFind->add('B');
        $this->assertCount(2, $unionFind);
    }

    protected function getUnionFindInstance(array $elements = []): AbstractUnionFind
    {
        return $this->getMockForAbstractClass(AbstractUnionFind::class, [$elements]);
    }

}