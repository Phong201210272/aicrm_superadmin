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
<<<<<<< HEAD
	
=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
    public function deductMoneyFromAdminWallet($id, $deductionMoney)
    {

        DB::beginTransaction();

        try {

            $user = User::find($id);
            if (!$user) {
                throw new Exception("User not found.");
            }


            if ($deductionMoney > $user->sub_wallet && $deductionMoney > $user->wallet) {
<<<<<<< HEAD
                Log::error('S? ti?n trong c? hai v� kh�ng d? d? th?c hi?n giao d?ch.');
                return response()->json(['error' => 'S? ti?n trong c? hai v� kh�ng d?'], 422);
=======
                Log::error('Số tiền trong cả hai ví không đủ để thực hiện giao dịch.');
                return response()->json(['error' => 'Số tiền trong cả hai ví không đủ'], 422);
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            }
            if ($deductionMoney <= $user->sub_wallet) {
                $user->sub_wallet -= $deductionMoney;
            } elseif ($deductionMoney <= $user->wallet) {
                $user->wallet -= $deductionMoney;
            }

<<<<<<< HEAD
            // Luu thay d?i
=======
            // Lưu thay đổi
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            $user->save();

            DB::commit();
            return response()->json(['success' => 'Transaction completed successfully', 'user' => $user], 200);
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Deduct money error: ' . $e->getMessage());
            return response()->json(['error' => 'Transaction failed'], 500);
        }
<<<<<<< HEAD
    }	
=======
    }
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
}
