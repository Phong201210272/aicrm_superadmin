<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
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
	
    public function deductMoneyFromAdminWallet($id, $deductionMoney)
    {

        DB::beginTransaction();

        try {

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found.");
            }


            if ($deductionMoney > $user->sub_wallet && $deductionMoney > $user->wallet) {
                Log::error('S? ti?n trong c? hai ví không d? d? th?c hi?n giao d?ch.');
                return response()->json(['error' => 'S? ti?n trong c? hai ví không d?'], 422);
            }
            if ($deductionMoney <= $user->sub_wallet) {
                $user->sub_wallet -= $deductionMoney;
            } elseif ($deductionMoney <= $user->wallet) {
                $user->wallet -= $deductionMoney;
            }

            // Luu thay d?i
            $user->save();

            DB::commit();
            return response()->json(['success' => 'Transaction completed successfully', 'user' => $user], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Deduct money error: ' . $e->getMessage());
            return response()->json(['error' => 'Transaction failed'], 500);
        }
    }	
}
