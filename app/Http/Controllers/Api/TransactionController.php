<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'amount' => $request->input('amount'),
                'status' => $request->input('status'),
                'user_id' => $request->input('user_id'),
                'notification' => $request->input('notification'),
                'description' => $request->input('description'),
            ]);

            DB::commit();
            return response()->json(['message' => 'Transaction created successfully']);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to create transaction: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to create transaction'], 500);
        }
    }
}
