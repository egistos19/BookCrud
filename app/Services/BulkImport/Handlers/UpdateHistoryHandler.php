<?php

namespace App\Services\BulkImport\Handlers;

use App\Models\ImportHistory;
use App\Enums\ImportStatus;

class UpdateHistoryHandler extends BaseHandler
{
    protected function process(array $data): array
    {
        if (!empty($data['history_id'])) {
            ImportHistory::where('id', $data['history_id'])
                ->update(['status' => ImportStatus::Completed]);
        }

        return $data;
    }
}
