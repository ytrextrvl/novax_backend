<?php

namespace App\Http\Controllers;

use App\Models\Flight;
use App\Models\City;
use Illuminate\Http\Request;

class FlightsController extends Controller
{
    public function search(Request $request)
    {
        $data = $request->validate([
            'from' => ['required','string','size:3'],
            'to' => ['required','string','size:3'],
            'date' => ['nullable','date'],
            'airline' => ['nullable','string','max:10'],
        ]);

        $q = Flight::query()
            ->where('from_city_id', strtoupper($data['from']))
            ->where('to_city_id', strtoupper($data['to']));

        if (!empty($data['date'])) {
            $q->whereDate('depart_at', $data['date']);
        }
        if (!empty($data['airline'])) {
            $q->where('airline_code', strtoupper($data['airline']));
        }

        return response()->json([
            'results' => $q->orderBy('depart_at')->limit(200)->get()
        ]);
    }

    public function manualCreate(Request $request)
    {
        $data = $request->validate([
            'airline_code' => ['required','string','max:10'],
            'from_city_id' => ['required','string','size:3','exists:cities,id'],
            'to_city_id' => ['required','string','size:3','exists:cities,id'],
            'depart_at' => ['required','date'],
            'arrive_at' => ['nullable','date'],
            'cabin_class' => ['nullable','string','max:50'],
            'base_price' => ['required','numeric','min:0'],
            'currency' => ['nullable','string','size:3'],
            'seats' => ['nullable','integer','min:0'],
            'status' => ['nullable','string','max:30'],
        ]);

        $flight = Flight::create([
            'airline_code' => strtoupper($data['airline_code']),
            'from_city_id' => strtoupper($data['from_city_id']),
            'to_city_id' => strtoupper($data['to_city_id']),
            'depart_at' => $data['depart_at'],
            'arrive_at' => $data['arrive_at'] ?? null,
            'cabin_class' => $data['cabin_class'] ?? 'economy',
            'base_price' => $data['base_price'],
            'currency' => $data['currency'] ?? 'USD',
            'seats' => $data['seats'] ?? null,
            'status' => $data['status'] ?? 'scheduled',
        ]);

        activity()->causedBy(auth('api')->user())->performedOn($flight)->log('flight.manual_create');

        return response()->json(['flight' => $flight], 201);
    }

    public function routes()
    {
        // Returns known city pairs from Yemen dataset & stored flights
        $pairs = Flight::query()
            ->selectRaw('from_city_id, to_city_id, count(*) as flights_count')
            ->groupBy('from_city_id','to_city_id')
            ->orderByDesc('flights_count')
            ->limit(500)
            ->get();

        return response()->json(['routes' => $pairs]);
    }

    public function ticketUpload(Request $request)
    {
        $data = $request->validate([
            'flight_id' => ['required','integer','exists:flights,id'],
            'ticket' => ['required','file','max:10240'], // 10MB
        ]);

        $path = $request->file('ticket')->store('tickets');

        activity()->causedBy(auth('api')->user())->log('flight.ticket_upload');

        return response()->json([
            'message' => 'Uploaded',
            'path' => $path,
        ]);
    }
}
