<?php

namespace App\Factories;

use App\Strategies\BookExport\{
    BookExportStrategy,
    HtmlExport,
    JsonExport,
    PdfExport
};

class BookExportFactory
{
    public static function make(string $format): BookExportStrategy
    {
        return match ($format) {
            'json' => new JsonExport(),
            'pdf' => new PdfExport(),
            default => new HtmlExport(),
        };
    }
}
