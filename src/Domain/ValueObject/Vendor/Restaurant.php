<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Vendor;

class Restaurant
{

    private $collection = [];
    public $name;
    public $location;
    public $size;

    public function add(MenuItem $item): void
    {
        if (!in_array($item, $this->collection)) {
            $this->collection[] = $item;
        }
    }
    /** @return  MenuItem[] */
    public function getMenu(): array
    {
        return $this->collection;
    }
}