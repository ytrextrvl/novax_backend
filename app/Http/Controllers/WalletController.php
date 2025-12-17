<?php

namespace App\Http\Controllers;

use App\Models\WalletTransaction;
use App\Models\Agency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public function wallet()
    {
        $user = auth('api')->user();

        return response()->json([
            'user_id' => $user->id,
            'agency_id' => null,
            'balance' => 0, // user wallet not modeled; agencies have balances
        ]);
    }

    public function credit(Request $request)
    {
        $data = $request->validate([
            'agency_id' => ['required','integer','exists:agencies,id'],
            'amount' => ['required','numeric','min:0.01'],
            'reference' => ['nullable','string','max:255'],
        ]);

        $user = auth('api')->user();

        $tx = DB::transaction(function () use ($data, $user) {
            $agency = Agency::lockForUpdate()->findOrFail($data['agency_id']);
            $agency->wallet_balance += (float)$data['amount'];
            $agency->save();

            return WalletTransaction::create([
                'user_id' => $user->id,
                'agency_id' => $agency->id,
                'type' => 'credit',
                'amount' => (float)$data['amount'],
                'balance_after' => (float)$agency->wallet_balance,
                'reference' => $data['reference'] ?? null,
            ]);
        });

        activity()->causedBy($user)->performedOn($tx)->log('wallet.credit');

        return response()->json(['transaction' => $tx], 201);
    }

    public function debit(Request $request)
    {
        $data = $request->validate([
            'agency_id' => ['required','integer','exists:agencies,id'],
            'amount' => ['required','numeric','min:0.01'],
            'reference' => ['nullable','string','max:255'],
        ]);

        $user = auth('api')->user();

        $tx = DB::transaction(function () use ($data, $user) {
            $agency = Agency::lockForUpdate()->findOrFail($data['agency_id']);

            if ($agency->wallet_balance < (float)$data['amount']) {
                abort(422, 'Insufficient balance');
            }

            $agency->wallet_balance -= (float)$data['amount'];
            $agency->save();

            return WalletTransaction::create([
                'user_id' => $user->id,
                'agency_id' => $agency->id,
                'type' => 'debit',
                'amount' => (float)$data['amount'],
                'balance_after' => (float)$agency->wallet_balance,
                'reference' => $data['reference'] ?? null,
            ]);
        });

        activity()->causedBy($user)->performedOn($tx)->log('wallet.debit');

        return response()->json(['transaction' => $tx], 201);
    }

    public function loyalty()
    {
        // Placeholder until loyalty engine is fully specified
        return response()->json(['points' => 0]);
    }
}
