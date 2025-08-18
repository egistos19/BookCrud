<?php

namespace App\Services\BulkImport\Handlers;

interface Handler
{
    public function setNext(Handler $handler): Handler;
    public function handle(array $data): array;
}
