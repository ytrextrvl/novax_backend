<?php

namespace App\Http\Controllers;

use App\Models\TravelRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RequestsController extends Controller
{
    public function create(Request $request)
    {
        $data = $request->validate([
            'type' => ['required','string', Rule::in(['flight'])],
            'agency_id' => ['nullable','integer','exists:agencies,id'],
            'flight_id' => ['nullable','integer','exists:flights,id'],
            'passengers' => ['required','array','min:1'],
            'amount' => ['required','numeric','min:0'],
            'currency' => ['nullable','string','size:3'],
            'notes' => ['nullable','string','max:5000'],
        ]);

        $tr = TravelRequest::create([
            'user_id' => auth('api')->id(),
            'agency_id' => $data['agency_id'] ?? null,
            'type' => $data['type'],
            'flight_id' => $data['flight_id'] ?? null,
            'passengers' => $data['passengers'],
            'status' => 'created',
            'amount' => $data['amount'],
            'currency' => $data['currency'] ?? 'USD',
            'payment_status' => 'unpaid',
            'notes' => $data['notes'] ?? null,
        ]);

        activity()->causedBy(auth('api')->user())->performedOn($tr)->log('request.create');

        return response()->json(['request' => $tr], 201);
    }

    public function show($id)
    {
        $tr = TravelRequest::findOrFail($id);

        // Basic ownership: admin can view all; user can view own
        $user = auth('api')->user();
        if (! $user->hasRole('admin') && $tr->user_id !== $user->id) {
            abort(403, 'Forbidden');
        }

        return response()->json(['request' => $tr]);
    }

    public function stateChange(Request $request, $id)
    {
        $tr = TravelRequest::findOrFail($id);

        $data = $request->validate([
            'status' => ['required','string', Rule::in(['created','in_review','approved','rejected','ticketed','cancelled'])],
        ]);

        $tr->status = $data['status'];
        $tr->save();

        activity()->causedBy(auth('api')->user())->performedOn($tr)->log('request.state_change');

        return response()->json(['request' => $tr]);
    }

    public function paymentVerify(Request $request, $id)
    {
        $tr = TravelRequest::findOrFail($id);

        $data = $request->validate([
            'reference' => ['required','string','max:255'],
            'status' => ['required','string', Rule::in(['paid','failed','pending'])],
        ]);

        $tr->payment_reference = $data['reference'];
        $tr->payment_status = $data['status'];
        $tr->save();

        activity()->causedBy(auth('api')->user())->performedOn($tr)->log('request.payment_verify');

        return response()->json(['request' => $tr]);
    }
}
