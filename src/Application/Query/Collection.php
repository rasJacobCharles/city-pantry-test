<?php

declare(strict_types=1);

namespace App\Application\Query;

class Collection
{
    private $items = [];

    public function count(): int
    {
        return count($this->items);
    }

    public function add(string $item): void
    {
        if (!in_array($item, $this->items)) {
            $this->items[] = $item;
        }
    }

    public function __toString(): string
    {
        return implode("", $this->items);
    }
}