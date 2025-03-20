<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Services\UserService;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    protected $userService;
    public function  __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        try {
            $users = $this->userService->getPaginatedUser();
            if (request()->ajax()) {
                $view = view('superadmin.user.table', compact('users'))->render();
                return response()->json(['success' => true, 'table' => $view]);
            }
            return view('superadmin.user.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Failed to find users: ' . $e->getMessage());
            return ApiResponse::error('Failed to get Users', 500);
        }
    }

    public function detail(Request $request)
    {
        try {
            return User::find($request->id);
        } catch (Exception $e) {
            Log::error('Failed to find this user: ' . $e->getMessage());
            return ApiResponse::error('Failed to find this user', 500);
        }
    }

    public function search(Request $request)
    {
        try {
            $query = $request->input('query');
            // Xử lý tìm kiếm theo tên hoặc số điện thoại
            if (preg_match('/\d/', $query)) {
                $users = $this->userService->getUserByPhone($query);
            } else {
                $users = $this->userService->getUserByName($query);
            }

            if ($request->ajax()) {
                $html = view('superadmin.user.table', compact('users'))->render();
                $pagination = $users->appends(['query' => $query])->links('pagination::custom')->render();
                return response()->json(['html' => $html, 'pagination' => $pagination]);
            }

            return view('superadmin.user.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Failed to search users: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to search users'], 500);
        }
    }

    public function store(Request $request)
    {
        // Validate dá»¯ liá»‡u Ä‘áº§u vÃ o
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'address' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'tax_code' => 'nullable|numeric',
            'username' => 'required|unique:users,username',
            'sub_wallet' => 'nullable',
            'prefix' => 'required|unique:users,prefix'
        ], [
            'name.required' => 'Vui l�ng di?n t�n kh�ch h�ng',
            'email.required' => 'Vui l�ng di?n email kh�ch h�ng',
            'phone.required' => 'Vui l�ng di?n s? di?n tho?i kh�ch h�ng',
            'address.required' => 'Vui l�ng di?n d?a ch? kh�ch h�ng',
            'username.required' => 'Vui l�ng di?n t�n t�i kho?n kh�ch h�ng',
            'prefix.required' => 'Vui l�ng di?n ti?n t? t�i kho?n',
            'prefix.unique' => 'Ti?n t? d� t?n t?i',
            'name.max' => 'T�n kh�ng du?c qu� :max k� t?',
            'username.unique' => 'T�n t�i kho?n d� t?n t?i',
            'phone.numeric' => 'S? di?n tho?i ph?i l� s?.',
            'phone.digits' => 'S? di?n tho?i ph?i d? 10 k� t?.',
            'phone.unique' => 'S? di?n tho?i n�y d� t?n t?i.',
            'email.email' => 'Email kh�ng d�ng d?nh d?ng.',
            'email.unique' => 'Email n�y d� t?n t?i.',
            'tax_code.numeric' => 'M� s? thu? ph?i l� s?.',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'validation_errors' => $validator->errors()
            ]);
        }
        try {
            // ThÃªm ngÆ°á»i dÃ¹ng má»›i
            $newUser = $this->userService->addNewUser($validated);
            Log::info('Tạo khách hàng mới thành công, bắt đầu tạo automation marketing');
            //Gá»­i request tá»›i API cá»§a Admin
            $adminApiUrl = config('app.api_url') . '/api/add-user';

            $client = new Client();

            $data = $request->all();

            $password = '123456';
            $hashedPassword = Hash::make($password);
            $sub_wallet = preg_replace('/[^\d]/', '', $request->sub_wallet);
            $data['role_id'] = 1; // ThÃªm role_id vÃ o dá»¯ liá»‡u gá»­i Ä‘i
            $data['password'] = $hashedPassword;
            $sub_wallet = preg_replace('/[^\d]/', '', $request->sub_wallet);
            if (empty($sub_wallet)) {
                $sub_wallet = 0; // GiÃ¡ trá»‹ máº·c Ä‘á»‹nh lÃ  0 náº¿u khÃ´ng cÃ³ giÃ¡ trá»‹
            }
            $data['sub_wallet'] = $sub_wallet;
            // $data['']
            Log::info($data);
            $response = $client->post($adminApiUrl, [
                'form_params' => $data, // Gá»­i táº¥t cáº£ dá»¯ liá»‡u bao gá»“m role_id
            ]);

            // Kiá»ƒm tra pháº£n há»“i tá»« API Admin
            if ($response->getStatusCode() !== 200) {
                throw new Exception('Failed to add user to Admin');
            } else {
                Log::info("user added to Admin successfully");
            }
            $automationUserApiUrl = config('app.api_url') . '/api/automation-user';

            $client2 = new Client();
            $response2 = $client2->post($automationUserApiUrl, [
                'form_params' => [
                    'user_id' => $newUser->id,
                ]
            ]);

            if ($response2->getStatusCode() !== 200) {
                throw new Exception('Failed to add automation to Admin');
            } else {
                Log::info('Automation User created successfully');
            }

            $automationRateApiUrl = config('app.api_url') . '/api/automation-rate';

            $rateClient = new Client();
            $rateResponse = $rateClient->post($automationRateApiUrl, [
                'form_params' => [
                    'user_id' => $newUser->id,
                ]
            ]);

            if ($rateResponse->getStatusCode() !== 200) {
                throw new Exception('Failed to add automation rate to Admin');
            } else {
                Log::info('Automation Rate created Successfully ');
            }

            $automationBirthdayApiUrl = config('app.api_url') . '/api/automation-birthday';

            $birthdayClient = new Client();
            $birthdayResponse = $birthdayClient->post($automationBirthdayApiUrl, [
                'form_params' => [
                    'user_id' => $newUser->id,
                ]
            ]);

            if ($birthdayResponse->getStatusCode() !== 200) {
                throw new Exception('Failed to add automation birthday to admin');
            } else {
                Log::info('Automation Birthday created successfully');
            }

            $automationReminderApiUrl = config('app.api_url') . '/api/automation-reminder';

            $reminderClient = new Client();
            $reminderResponse = $reminderClient->post($automationReminderApiUrl, [
                'form_params' => [
                    'user_id' => $newUser->id,
                ]
            ]);

            if ($reminderResponse->getStatusCode() !== 200) {
                throw new Exception('Failed to add automation reminder to admin');
            } else {
                Log::info('Automation Reminder created successfully');
            }

            // Láº¥y danh sÃ¡ch ngÆ°á»i dÃ¹ng Ä‘Ã£ phÃ¢n trang
            $paginatedUsers = $this->userService->getPaginatedUser();

            return response()->json([
                'success' => 'Thêm khách hàng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render(),
            ]);
        } catch (Exception $e) {
            // Ghi log chi tiáº¿t hÆ¡n vá» lá»—i
            Log::error('Failed to add new User: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Thêm khách hàng thất bại'
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $months = $user->created_at->diffInMonths($user->expired_at);
        return response()->json(['user' => $user, 'months' => $months]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
            'phone' => 'required|numeric|digits:10|unique:users,phone,' . $request->user_id,
            'address' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'tax_code' => 'nullable|numeric',
            'username' => 'required|unique:users,username,' . $request->user_id,
            'sub_wallet' => 'nullable',
            'prefix' => 'required|unique:users,prefix,' . $request->user_id
        ], [
            'username.unique' => 'Tên tài khoản đã tồn tại',
            'username.required' => 'Tên tài khoản không được trống',
            'phone.required' => 'Số điện thoại không được trống',
            'phone.numeric' => 'Số điện thoại phải là số.',
            'phone.digits' => 'Số điện thoại phải đủ 10 ký tự.',
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
            'email.required' => 'Email không được trống',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã tồn tại.',
            'tax_code.numeric' => 'Mã số thuế phải là số.',
            'address.required' => 'Vui lòng điền địa chỉ khách hàng',
            'prefix.required' => 'Vui lòng điền tiền tố tài khoản',
            'prefix.unique' => 'Tiền tố đã tồn tại',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'validation_errors' => $validator->errors()
            ]);
        }
        $data = $request->all();
        //Cập nhật hạn sử dụng
        $createdAt = User::select('created_at')->find($request->user_id)->created_at;
        $data['expired_at'] = $createdAt->copy()->addMonths($request->expired_at)->toDateTimeString();
        Log::info($data);
        /////////////////////
        $apiURL = config('app.api_url') . 'api/update-user';
        $response = Http::post($apiURL, $data);
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to update user to Admin');
            return response()->json(['error' => true, 'api_errors' => 'Cập nhật người dùng vào Admin không thành công'], 500);
        }
        $newUser = $this->userService->updateUser($data);
        $paginatedUsers = $this->userService->getPaginatedUser();
        return response()->json([
            'success' => 'Cập nhật khách hàng thành công',
            'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
            'pagination' => $paginatedUsers->links('pagination::custom')->render()
        ]);
    }
    public function delete(Request $request)
    {
        try {
            $id = $request->id;
            $phone = User::select('phone')->find($id)->phone;
            $apiURL = config('app.api_url') . 'api/delete-user';
            $response = Http::delete($apiURL, [
                'phone' => $phone
            ]);
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Xóa người dùng không thành công ở phía API'
                ], $response->status());
            }
            $this->userService->deleteUserByPhone($phone);
            $paginatedUsers = $this->userService->getPaginatedUser();
            return response()->json([
                'success' => 'Xóa khách hàng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render()
            ]);
        } catch (Exception $e) {
            Log::error('Failed to delete user: ' . $e->getMessage(), [
                'user_id' => $request->id
            ]);

            return response()->json([
                'error' => 'Xóa người dùng không thành công'
            ], 500);
        }
    }
}
