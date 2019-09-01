<?php

declare(strict_types=1);


namespace App\Domain\ValueObject\Vendor;


use App\Infrastructure\Delivery\Exception\AdvanceTimeException;
use DateInterval;
use DateTime;

class MenuItem
{
    private $name;
    private $allergies;
    public $minOrderDate;

    public function __construct(string $name, string $allergies, string $prepareTime)
    {
        $date = new DateTime();

        try {
            $date->add(
                new DateInterval(
                    sprintf(
                        'PT%s',
                        rtrim(strtoupper($prepareTime))
                    )
                )
            );
        } catch (\Throwable $exception) {
            throw new AdvanceTimeException();
        }

        $this->name = $name;
        $this->allergies = $allergies;
        $this->minOrderDate = $date;
    }

    public function __toString(): string
    {
       return implode(';', [$this->name, $this->allergies]);
    }
}