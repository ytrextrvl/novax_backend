<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'causer_id' => ['nullable','integer'],
            'event' => ['nullable','string','max:255'],
        ]);

        $q = Activity::query()->latest();

        if (!empty($data['causer_id'])) $q->where('causer_id', $data['causer_id']);
        if (!empty($data['event'])) $q->where('description', 'like', '%'.$data['event'].'%');

        return response()->json([
            'logs' => $q->limit(200)->get()
        ]);
    }
}
