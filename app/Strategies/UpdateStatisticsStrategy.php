<?php
namespace App\Strategies;

use App\Models\Book;
use Illuminate\Support\Facades\Log;

class UpdateStatisticsStrategy implements BookProcessingStrategy
{
    public function execute(array $bookData): void
    {
        $totalBooks = Book::count();
        Log::info("Toplam kitap sayısı güncellendi: $totalBooks");
    }
}
