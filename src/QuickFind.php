<?php

namespace Cancio\Ds\UnionFind;

class QuickFind extends AbstractUnionFind
{

    public function getRoot(string $p): string
    {
        $this->assertElementExists($p);

        return $this->unionFind[$p];
    }

    public function remove(string $p): UnionFindInterface
    {
        $this->assertElementExists($p);

        foreach ($this->unionFind as $q => $value) {
            if ($p !== $q && $p === $value) {
                $this->remove($q);
            }
        }

        unset($this->unionFind[$p]);

        return $this;
    }

    public function unite(string $p, string $q): UnionFindInterface
    {
        $this->assertElementExists($p);
        $this->assertElementExists($q);

        $p_id = $this->unionFind[$p];
        $q_id = $this->unionFind[$q];

        foreach ($this->unionFind as $i => $value) {
            if ($value === $p_id) {
                $this->unionFind[$i] = $q_id;
            }
        }

        return $this;
    }

}