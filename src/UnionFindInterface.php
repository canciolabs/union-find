<?php

namespace Cancio\Ds\UnionFind;

use Countable;

interface UnionFindInterface extends Countable
{

    /**
     * Add a new element to the union.
     * @param string $p
     * @return $this
     */
    public function add(string $p): UnionFindInterface;

    /**
     * Returns all elements of the union.
     * @return string[]
     */
    public function all(): array;

    /**
     * Check if two elements are connected.
     * @param string $p
     * @param string $q
     * @return bool
     */
    public function areConnected(string $p, string $q): bool;

    /**
     * Clears the current union.
     * @return $this
     */
    public function clear(): self;

    /**
     * Copies the current union.
     * @return self
     */
    public function copy(): self;

    /**
     * Check if a given element exists.
     * @param string $p
     * @return bool
     */
    public function has(string $p): bool;

    /**
     * Find the root of a given element.
     * @param string $p
     * @return string
     */
    public function getRoot(string $p): string;

    /**
     * Remove a given element from the union.
     * @param string $p
     * @return $this
     */
    public function remove(string $p): UnionFindInterface;

    /**
     * Sets the items.
     * @param string[] $items
     * @return $this
     */
    public function set(array $items): UnionFindInterface;

    /**
     * Unite two given elements.
     * @param string $p
     * @param string $q
     * @return $this
     */
    public function unite(string $p, string $q): UnionFindInterface;

    /**
     * Converts the union to an array.
     * @return string[]
     */
    public function toArray(): array;

}