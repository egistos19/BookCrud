<?php

namespace App\Services\BulkImport\Handlers;

abstract class BaseHandler
{
    protected ?BaseHandler $next = null;

    public function setNext(BaseHandler $handler): BaseHandler
    {
        $this->next = $handler;
        return $handler;
    }

    public function handle(array $data): array
    {
        $data = $this->process($data);

        if ($this->next) {
            return $this->next->handle($data);
        }

        return $data;
    }

    abstract protected function process(array $data): array;
}
