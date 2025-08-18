<?php
namespace App\Strategies;

class BookProcessor
{
    protected BookProcessingStrategy $strategy;

    public function setStrategy(BookProcessingStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function process(array $bookData): void
    {
        $this->strategy->execute($bookData);
    }
}
