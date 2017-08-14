<?php
namespace InterNations\Component\Solr;

interface ExpressionInterface
{
    public function isEqual(string $expr): bool;
    public function __toString(): string;
}
