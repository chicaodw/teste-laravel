<?php

namespace App\Helpers;

use App\Models\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogHelper
{
    public static function log($action, $model = null, $modelId = null, $description = null)
    {
        Log::create([
            'user_id'    => Auth::id(),
            'action'     => $action,
            'model'      => $model,
            'model_id'   => $modelId,
            'description'=> $description,
            'ip'         => Request::ip(),
        ]);
    }
}
