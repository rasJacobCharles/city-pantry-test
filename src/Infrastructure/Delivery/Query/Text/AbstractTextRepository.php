<?php

declare(strict_types=1);


namespace App\Infrastructure\Delivery\Query\Text;


use App\Application\Query\Collection;
use App\Application\Query\Delivery\QueryInterface;
use App\Infrastructure\Delivery\Exception\InvalidFilePathException;
use Throwable;

abstract class AbstractTextRepository
{
    protected $loadedContent;

    public function __construct(string $filename)
    {
        $this->loadedContent = $this->loadContent($filename);
    }

    private function loadContent(string $filename): array
    {
        try {
            $content = [];
            $handle = fopen($filename, "r");

            while (!feof($handle)) {
                $content[] = fgets($handle);
            }
            fclose($handle);

            return $content;
        } catch (Throwable $exception) {
            throw new InvalidFilePathException();
        }
    }

    abstract public function find(QueryInterface $query): Collection;
}