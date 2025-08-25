<?php
namespace App\Strategies\BookExport;

use App\Models\Book;

class JsonExport implements BookExportStrategy
{
    public function export(Book $book): string
    {
        return json_encode([
            'name' => $book->name,
            'author' => $book->author->name,
            'isbn' => $book->isbn,
        ]);
    }
}
