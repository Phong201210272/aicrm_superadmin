<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ZnsMessage;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MessageController extends Controller
{
    public function addMessage(Request $request)
    {
        Log::info('Receiving data from Admin ', $request->all());
        try {
            ZnsMessage::create($request->all());
            Log::info('Message added to SuperAdmin Successfully');
            return response()->json(['success' => 'Thêm Zalo Super Admin thành công']);
        } catch (Exception $e) {
            Log::error('Failed to add zalo to Super Admin: ' . $e->getMessage());
            return response()->json(['error' => 'Thêm Zalo Super Admin thất bại']);
        }
    }
}
