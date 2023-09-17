<?php

namespace Cancio\Ds\UnionFind\Contracts;

interface DescendentAwareInterface
{

    /**
     * Returns a list of all descendents of a given element.
     * @param string $p
     * @return string[]
     */
    public function getDescendents(string $p): array;

}