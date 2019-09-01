<?php

declare(strict_types=1);

namespace App\Infrastructure\Delivery\Query\Text;

use App\Application\Query\Collection;
use App\Application\Query\Delivery\FindVendor;
use App\Application\Query\Delivery\QueryInterface;
use App\Domain\ValueObject\Vendor\MenuItem;
use App\Domain\ValueObject\Vendor\Restaurant;
use DateTime;

class VendorRepository extends AbstractTextRepository
{
    private const REGEX_PATTERN_STRING ='/^.*\d$/m';

    private $location;
    private $name;
    private $collection = [];

    public function find(QueryInterface $query): Collection
    {
        /** @var FindVendor $query */
        $searchResult = new Collection();
        $this->processVendor();


        foreach ($this->collection[$query->location] ?? [] as $vendor) {
            /** @var Restaurant $vendor */
            if ($query->covers <= $vendor->size) {
                $this->addDeliverableMenuItem($vendor, $searchResult, $query->date);
            }
        }

        return $searchResult;
    }

    private function processVendor(): void
    {
        foreach ($this->loadedContent as $value) {
            if(false === $value) {
                continue;
            }
            if (preg_match(self::REGEX_PATTERN_STRING, $value)) {
                $this->createVendor($value);
            } else {
                 $this->addMenuItem($value);
            }
        }
    }

    private function addDeliverableMenuItem(Restaurant $restaurant, Collection &$collection, DateTime $orderDate)
    {
        foreach ($restaurant->getMenu() as $menuItem) {
            if ($menuItem->minOrderDate < $orderDate) {
                $collection->add((string) $menuItem);
            }
        }
    }

    private function createVendor(string $value): void
    {
        $result = explode(';', $value);
        $this->location = strtoupper(substr($result[1], 0 , 2));
        $this->name = $result[0];
        $restaurant = new Restaurant();
        $restaurant->name = $this->name;
        $restaurant->location = $result[1];
        $restaurant->size = (int) $result[2];
        $this->collection[$this->location][] =   $restaurant;

    }

    private function addMenuItem(string $value): void
    {
        $result = explode(';', $value);

        if (!isset($value[1])) {
            return;
        }

        foreach ($this->collection[$this->location] as $item) {
            /** @var Restaurant $item */
            if ($item->name === $this->name){
                $item->add(new MenuItem($result[0],$result[1], $result[2]));
            }
        }
    }
}
