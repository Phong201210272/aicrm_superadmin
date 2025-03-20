<?php

namespace App\Services;

use App\Models\OaTemplate;
use App\Models\User;
use App\Models\ZaloOa;
use App\Models\ZnsMessage;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;


class ZaloOaService
{
    protected $oaTemplate;
    protected $zaloOa;
    protected $znsMessage;
    protected $client;

    public function __construct(OaTemplate $oaTemplate, ZaloOa $zaloOa, ZnsMessage $znsMessage, Client $client)
    {
        $this->oaTemplate = $oaTemplate;
        $this->zaloOa = $zaloOa;
        $this->znsMessage = $znsMessage;
        $this->client = $client;
    }

    public function getPaginatiedOas()
    {
        try {
            $parentUserIds = User::whereNull('parent_id')->orWhere('parent_id', '')->pluck('id');

            $zaloOas = $this->zaloOa
                ->whereIn('user_id', $parentUserIds) // Giả sử bảng zaloOa có cột user_id
                ->orderByDesc('created_at')
                ->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to get paginated oa list: ' . $e->getMessage());
            throw new Exception('Failed to get paginated oa list');
        }
    }

    public function getOaByColumn($column, $value)
    {
        try {
            // Lấy danh sách user_id của những người dùng cấp cao nhất (parent_id null hoặc rỗng)
            $parentUserIds = User::whereNull('parent_id')
                ->orWhere('parent_id', '')
                ->pluck('id');

            // Truy vấn OA dựa trên cột được chỉ định
            return $this->zaloOa
                ->whereIn('user_id', $parentUserIds)
                ->where($column, 'LIKE', '%' . $value . '%')
                ->orderByDesc('created_at')
                ->paginate(10);
        } catch (\Exception $e) {
            Log::error("Failed to find OA by $column: " . $e->getMessage());
            throw new \Exception("Failed to find OA by $column");
        }
    }

    public function getOaByOaId($id)
    {
        return ZaloOa::where('oa_id', $id);
    }

    public function getOaByName($name)
    {
        return ZaloOa::where('name', 'like', "%{$name}%");
    }
}
