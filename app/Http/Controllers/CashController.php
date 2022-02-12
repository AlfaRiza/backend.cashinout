<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CashController extends Controller
{
    public function index()
    {
        $debit = Auth::user()->cashes()
                ->whereBetween('when', [ now()->firstOfMonth(), now() ])
                ->where('amount', '>=', 0)
                ->get('amount')->sum('amount');
        $credit = Auth::user()->cashes()
                ->whereBetween('when', [ now()->firstOfMonth(), now() ])
                ->where('amount', '<', 0)
                ->get('amount')->sum('amount');

        $balances = Auth::user()->cashes()->get('amount')->sum('amount');
        return response()->json(compact('debit', 'credit', 'balances'));
    }
    public function store(Request $request)
    {
        request()->validate([
            'name'  => 'required',
            'amount'    => 'required|numeric',
        ]);

        $slug = request('name') . '-' . str()->random(6);
        $when = request('when') ?? now();
        Auth::user()->cashes()->create([
            'name'  => request('name'),
            'slug'  => str()->slug($slug),
            'when'  => $when,
            'amount'    => request('amount'),
            'description'    => request('description')
        ]);

        return response()->json([
            'message' => 'The transaction has been save'
        ]);
    }
}
