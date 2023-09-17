<?php

namespace Cancio\Ds\UnionFind\Contracts;

interface AncestorAwareInterface
{

    /**
     * Returns a list of all ancestors of a given element.
     * @param string $p
     * @return string[]
     */
    public function getAncestors(string $p): array;

}