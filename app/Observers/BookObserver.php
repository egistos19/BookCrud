<?php

namespace App\Observers;

use App\Models\Book;
use App\Services\WebhookNotifier;
use App\Strategies\BookProcessor;
use App\Strategies\UpdateStatisticsStrategy;
use App\Strategies\UppercaseTitleStrategy;

class BookObserver
{
    public function created(Book $book)
    {
        WebhookNotifier::sendToWebhookSite($book);
        WebhookNotifier::sendToSemihKeskinNet($book);

        $processor = new BookProcessor();


        $processor->setStrategy(new UpdateStatisticsStrategy());
        $processor->process(['book_id' => $book->id]);

        $processor->setStrategy(new UppercaseTitleStrategy());
        $processor->process(['title' => $book->name]);
    }
}
