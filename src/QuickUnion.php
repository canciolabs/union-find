<?php

namespace Cancio\Ds\UnionFind;

use Cancio\Ds\UnionFind\Contracts\QuickUnionInterface;
use Cancio\Ds\UnionFind\Contracts\UnionFindInterface;
use Ds\Queue;

class QuickUnion extends AbstractUnionFind implements QuickUnionInterface
{

    public function getRoot(string $p): string
    {
        $this->assertElementExists($p);

        while ($p !== $this->unionFind[$p]) {
            $p = $this->unionFind[$p];
        }

        return $p;
    }

    public function unite(string $p, string $q): UnionFindInterface
    {
        $this->assertElementExists($p);
        $this->assertElementExists($q);

        $i = $this->getRoot($p);
        $j = $this->getRoot($q);

        $this->unionFind[$i] = $j;

        return $this;
    }

    public function remove(string $p): UnionFindInterface
    {
        $this->assertElementExists($p);

        foreach ($this->getDescendents($p) as $descendent) {
            unset($this->unionFind[$descendent]);
        }

        unset($this->unionFind[$p]);

        return $this;
    }

    public function getAncestors(string $p): array
    {
        $this->assertElementExists($p);

        $ancestors = [];

        while ($p !== $this->unionFind[$p]) {
            $ancestors[] = $this->unionFind[$p];

            $p = $this->unionFind[$p];
        }

        return $ancestors;
    }

    public function getDescendents(string $p): array
    {
        $this->assertElementExists($p);

        $descendents = [];

        $queue = new Queue();
        $queue->push($p);

        while (!$queue->isEmpty()) {
            $q = $queue->pop();

            // Add all children of "$q" to the queue
            foreach ($this->unionFind as $id => $parent_id) {
                if ($id !== $q && $parent_id === $q) {
                    $descendents[] = $id;
                    $queue->push($id);
                }
            }
        }

        return array_unique($descendents);
    }

}