<?php

namespace App\Http\Controllers;

use App\Models\Agency;
use Illuminate\Http\Request;

class AgenciesController extends Controller
{
    public function index()
    {
        return response()->json(['agencies' => Agency::query()->orderBy('name')->get()]);
    }

    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'type' => ['nullable','string','max:50'],
            'commission_rate' => ['nullable','numeric','min:0'],
        ]);

        $agency = Agency::create([
            'name' => $data['name'],
            'type' => $data['type'] ?? 'agency',
            'commission_rate' => $data['commission_rate'] ?? 0,
            'wallet_balance' => 0,
        ]);

        activity()->causedBy(auth('api')->user())->performedOn($agency)->log('agency.create');

        return response()->json(['agency' => $agency], 201);
    }

    public function balance($id)
    {
        $agency = Agency::findOrFail($id);
        return response()->json([
            'agency_id' => $agency->id,
            'wallet_balance' => $agency->wallet_balance,
        ]);
    }

    public function commission(Request $request, $id)
    {
        $agency = Agency::findOrFail($id);

        $data = $request->validate([
            'commission_rate' => ['required','numeric','min:0'],
        ]);

        $agency->commission_rate = $data['commission_rate'];
        $agency->save();

        activity()->causedBy(auth('api')->user())->performedOn($agency)->log('agency.commission_update');

        return response()->json(['agency' => $agency]);
    }
}
