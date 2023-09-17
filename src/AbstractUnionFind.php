<?php

namespace Cancio\Ds\UnionFind;

use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Cancio\Ds\UnionFind\Exception\DuplicateElementException;
use Cancio\Ds\UnionFind\Exception\ElementNotFoundException;

abstract class AbstractUnionFind implements UnionFindInterface
{

    protected array $unionFind = [];

    public function __construct(array $items = [])
    {
        $this->set($items);
    }

    public function add(string $p): UnionFindInterface
    {
        $this->assertElementNotExists($p);

        $this->unionFind[$p] = $p;

        return $this;
    }

    public function all(): array
    {
        return array_keys($this->unionFind);
    }

    public function clear(): UnionFindInterface
    {
        $this->unionFind = [];

        return $this;
    }

    public function copy(): UnionFindInterface
    {
        return clone $this;
    }

    public function count(): int
    {
        return count($this->unionFind);
    }

    public function areConnected(string $p, string $q): bool
    {
        $this->assertElementExists($p);
        $this->assertElementExists($q);

        return $this->getRoot($p) === $this->getRoot($q);
    }

    public function has(string $p): bool
    {
        return array_key_exists($p, $this->unionFind);
    }

    public function set(array $items): UnionFindInterface
    {
        $this->unionFind = [];

        foreach ($items as $item) {
            $this->add((string) $item);
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->unionFind;
    }

    protected function assertElementExists(string $p): void
    {
        if (!$this->has($p)) {
            throw new ElementNotFoundException($p);
        }
    }

    protected function assertElementNotExists(string $p): void
    {
        if ($this->has($p)) {
            throw new DuplicateElementException($p);
        }
    }

}