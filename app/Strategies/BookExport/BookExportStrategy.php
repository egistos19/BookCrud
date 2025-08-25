<?php

namespace App\Strategies\BookExport;

use App\Models\Book;

interface BookExportStrategy
{
    public function export(Book $book): string;
}
