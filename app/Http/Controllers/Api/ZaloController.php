<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ZaloOa;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ZaloController extends Controller
{
    public function addZalo(Request $request)
    {
        Log::info('Receiving data from Admin ', $request->all());
        try {
            ZaloOa::create($request->all());
            Log::info('Zalo added to SuperAdmin Successfully');
            return response()->json(['success' => 'Thêm Zalo Super Admin thành công']);
        } catch (Exception $e) {
            Log::error('Failed to add zalo to Super Admin: ' . $e->getMessage());
            return response()->json(['error' => 'Thêm Zalo Super Admin thất bại']);
        }
    }
}
