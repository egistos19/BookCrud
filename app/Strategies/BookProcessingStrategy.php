<?php
namespace App\Strategies;

interface BookProcessingStrategy
{
    public function execute(array $bookData): void;
}