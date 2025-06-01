<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $logs = Log::with('user')
            ->when($search, function ($query) use ($search) {
                $term = '%' . $search . '%';

                $query->where(function ($q) use ($term) {
                    $q->where('action', 'like', $term)
                      ->orWhere('model', 'like', $term)
                      ->orWhere('model_id', 'like', $term)
                      ->orWhereHas('user', function ($uq) use ($term) {
                          $uq->where('name', 'like', $term)
                             ->orWhere('email', 'like', $term);
                      });
                });
            })
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('logs.index', compact('logs'));
    }
}