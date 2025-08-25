<?php

namespace App\Strategies\BookExport;

use App\Models\Book;

class PdfExport implements BookExportStrategy
{
    public function export(Book $book): string
    {
        // Gerçek PDF için dompdf/snappy gibi kütüphaneler kullanılabilir.
        return "PDF Export: {$book->name} - {$book->author->name}";
    }
}
