<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Book;

class WebhookNotifier
{
    public static function sendToWebhookSite(Book $book)
    {
        Http::post('https://webhook.site/d8bbb449-6533-420b-b5cb-f6f2b33ec55f', [
            'book' => $book->only(['id', 'name', 'isbn']),
        ]);
    }

    public static function sendToSemihKeskinNet(Book $book)
    {
        Http::post('https://semihkeskin.net', [
            'book' => $book->only(['id', 'name', 'isbn']),
        ]);
    }
}
