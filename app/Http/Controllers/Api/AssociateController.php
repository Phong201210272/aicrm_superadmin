<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AssociateController extends Controller
{
    public function store(Request $request)
    {
        Log::info('Receiving data from Admin: ', $request->all());
        try {
            User::create($request->all());
            return response()->json(['success' => 'Associate added successfully']);
        } catch (Exception $e) {
            Log::error('Failed to add associate in Super Admin: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to add associate']);
        }
    }

    public function update(Request $request)
    {
        Log::info('Receiving data from Admin: ', $request->all());
        try {
            $associate = User::findOrFail($request->id);
            $associate->update($request->all());
            Log::info('Successfully updated associate in Super Admin ', ['id' => $request->id]);
            return response()->json(['success' => 'Associate updated successfully']);
        } catch (ModelNotFoundException $e) {
            Log::error('Associate not found in superadmin', ['id' => $request->id]);
            return response()->json(['success' => 'Associate not found'], 404);
        } catch (Exception $e) {
            Log::error('Failed to delete associate in super admin: ', ['id' => $request->id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to update associate'], 500);
        }
    }

    public function delete(Request $request)
    {
        try {
            Log::info('Receiving delete request in Super Admin', ['id' => $request->id]);

            // Tìm associate theo id
            $associate = User::findOrFail($request->id);
            // Xóa associate
            $associate->delete();
            Log::info('Successfully deleted associate in Super Admin', ['id' => $request->id]);

            return response()->json(['success' => 'Associate deleted successfully']);
        } catch (ModelNotFoundException $e) {
            Log::error('Associate not found in Super Admin', ['id' => $request->id]);
            return response()->json(['error' => 'Associate not found'], 404);
        } catch (Exception $e) {
            Log::error('Failed to delete associate in Super Admin', ['id' => $request->id, 'error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to delete associate'], 500);
        }
    }
}
