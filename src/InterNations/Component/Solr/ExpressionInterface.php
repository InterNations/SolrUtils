<?php
namespace InterNations\Component\Solr;

interface ExpressionInterface
{
    /** @no-named-arguments */
    public function isEqual(string $expr): bool;

    /** @no-named-arguments */
    public function __toString(): string;
}
