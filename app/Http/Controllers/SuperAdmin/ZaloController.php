<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Models\ZaloOa;
use App\Models\ZnsMessage;
use App\Services\ZaloOaService;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ZaloController extends Controller
{
    protected $zaloService;
    public function __construct(ZaloOaService $zaloService)
    {
        $this->zaloService = $zaloService;
    }
    public function index()
    {
        try {
            // Lấy ID của người dùng không có parent_id
            $parentUserIds = User::whereNull('parent_id')->orWhere('parent_id', '')->pluck('id');

            // Lấy danh sách OA (ZaloOa) theo user_id
            $zaloOas = ZaloOa::whereIn('user_id', $parentUserIds)
                ->orderByDesc('created_at')
                ->paginate(10);

            // Lấy mảng oa_id từ các ZaloOa đã truy vấn
            $oaIds = $zaloOas->pluck('oa_id')->unique();

            // Đếm số tin nhắn của các OA có oa_id giống nhau
            foreach ($zaloOas as $zaloOa) {
                // Lấy tất cả các OA có cùng oa_id
                $matchingOas = ZaloOa::where('oa_id', $zaloOa->oa_id)->get();

                // Đếm số tin nhắn cho các OA này
                $zaloOa->message_count = ZnsMessage::whereIn('oa_id', $matchingOas->pluck('id'))->count();
            }

            if (request()->ajax()) {
                $table = view('superadmin.zalo.table', compact('zaloOas'))->render();
                $pagination = $zaloOas->links('vendor.pagination.custom')->toHtml();

                return response()->json([
                    'success' => true,
                    'html' => $table,
                    'pagination' => $pagination,
                ]);
            }

            return view('superadmin.zalo.index', compact('zaloOas'));
        } catch (Exception $e) {
            Log::error('Lỗi khi lấy danh sách OA: ' . $e->getMessage());
            return ApiResponse::error('Lỗi khi lấy danh sách OA', 500);
        }
    }



    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            Log::info('Start finding OA with OA ID or name equals to ' . $query);
            // Kiểm tra query là số hay chữ
            if (preg_match('/\d/', $query)) {
                $zaloOaQuery = $this->zaloService->getOaByOaId($query);
            } else {
                $zaloOaQuery = $this->zaloService->getOaByName($query);
            }
            Log::info('OA found successfully, start counting oas messages');
            $parentUserIds = User::whereNull('parent_id')->orWhere('parent_id', '')->pluck('id');

            // Lấy danh sách OA (ZaloOa) theo user_id
            $zaloOas = $zaloOaQuery->whereIn('user_id', $parentUserIds)
                ->orderByDesc('created_at')
                ->paginate(10);

            // Lấy mảng oa_id từ các ZaloOa đã truy vấn
            $oaIds = $zaloOas->pluck('oa_id')->unique();

            // Đếm số tin nhắn của các OA có oa_id giống nhau
            foreach ($zaloOas as $zaloOa) {
                // Lấy tất cả các OA có cùng oa_id
                $matchingOas = ZaloOa::where('oa_id', $zaloOa->oa_id)->get();

                // Đếm số tin nhắn cho các OA này
                $zaloOa->message_count = ZnsMessage::whereIn('oa_id', $matchingOas->pluck('id'))->count();
            }

            Log::info('finish');

            if ($request->expectsJson()) {
                Log::info('Detected AJAX request, rendering partial view.');
                $html = view('superadmin.zalo.table', compact('zaloOas'))->render();
                $pagination = $zaloOas->appends(['query' => $query])->links();

                Log::info('Response HTML:', ['html' => $html]);
                Log::info('Pagination Debug:', ['pagination_data' => $zaloOas->toArray()]);

                return response()->json([
                    'html' => $html,
                    'pagination' => $pagination
                ]);
            }


            Log::info('redering view without ajax request');
            return view('superadmin.zalo.index', compact('zaloOas'));
        } catch (Exception $e) {
            Log::error('Lỗi tìm kiếm ZaloOa: ' . $e->getMessage());
            return response()->json(['error' => 'Không thể tìm kiếm OA'], 500);
        }
    }
}
