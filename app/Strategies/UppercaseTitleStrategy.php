<?php

namespace App\Strategies;

use Illuminate\Support\Facades\Log;

class UppercaseTitleStrategy implements BookProcessingStrategy
{
    public function execute(array $data): void
    {
        $title = $data['title'] ?? '';
        $uppercase = strtoupper($title);

        Log::info("Kitap Büyük harflerle gösterildi: {$uppercase}");
    }
}


