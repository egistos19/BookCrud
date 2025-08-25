<?php

namespace App\Strategies\BookExport;

use App\Models\Book;

class HtmlExport implements BookExportStrategy
{
    public function export(Book $book): string
    {
        return "<h1>{$book->name}</h1>
                <p>Author: {$book->author->name}</p>
                <p>ISBN: {$book->isbn}</p>";
    }
}
