<?php

namespace App\Enums;;

enum ImportStatus: string
{
    case Uploaded = 'uploaded';
    case Completed = 'completed';
    case Failed = 'failed';
}