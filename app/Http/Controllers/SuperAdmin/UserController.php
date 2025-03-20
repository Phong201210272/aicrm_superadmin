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
                $table = view('superadmin.user.table', compact('users'))->render();
                $pagination = $users->links('vendor.pagination.custom')->toHtml();
                return response()->json([
                    'success' => true,
                    'html' => $table,
                    'pagination' => $pagination,
                ]);
            }
            return view('superadmin.user.index', compact('users'));
        } catch (Exception $e) {
            Log::error('Failed to find users: ' . $e->getMessage());
            return ApiResponse::error('Failed to get Users', 500);
        }
    }

    public function detail($id)
    {
        try {
            $user = User::find($id);
            return response()->json($user);
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
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'address' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'tax_code' => 'nullable|numeric',
            'sub_wallet' => 'nullable',
            'prefix' => 'required|unique:users,prefix',
            'wallet' => 'nullable',
        ], [
            'name.required' => 'Vui lòng nhập tên người dùng',
            'email.required' => 'Vui lòng nhập email',
            'phone.required' => 'Vui lòng nhập số điện thoại người dùng',
            'address.required' => 'Vui lòng nhập địa chỉ',
            'prefix.required' => 'Vui lòng nhập tiền tố',
            'prefix.unique' => 'Tiền tố đã tồn tại',
            'username.unique' => 'Tên đăng nhập đã tồn tại',
            'phone.numeric' => 'Số điện thoại phải là số',
            'phone.digits' => 'Số điện thoại phải đủ 10 ký tự',
            'phone.unique' => 'Số điện thoại đã tồn tại',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã tồn tại',
            'tax_code.numeric' => 'Mã số thuế phải là số',
            'address.required' => 'Vui lòng nhập địa chỉ người dùng'
        ]);
        try {
            $validated['role_id'] = 1;
            $validated['username'] = strtolower($request->prefix);
            $validated['password'] = Hash::make('123456');
            $validated['wallet'] = preg_replace('/[^\d]/', '', $request->wallet) ?: 0;
            $validated['sub_wallet'] = preg_replace('/[^\d]/', '', $request->sub_wallet) ?: 0;

            $newUser = $this->userService->addNewUser($validated);

            Log::info('Tạo người dùng mới thành công.');

            // Gửi request API Admin
            $adminApiUrl = config('app.api_url') . '/api/add-user';

            $client = new Client();
            $response = $client->post($adminApiUrl, [
                'form_params' => $validated,
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new Exception('Failed to add user to Admin');
                return response()->json(['error' => 'Thêm người dùng vào Admin không thành công'], 500);
            }

            Log::info('User added to Admin successfully');

            // Automation APIs
            $automationEndpoints = [
                '/api/automation-user',
                '/api/automation-rate',
                '/api/automation-birthday',
                '/api/automation-reminder'
            ];

            foreach ($automationEndpoints as $endpoint) {
                $client->post(config('app.api_url') . $endpoint, [
                    'form_params' => ['user_id' => $newUser->id],
                ]);
            }

            Log::info('All automation tasks completed successfully.');

            // Lấy danh sách người dùng đã phân trang
            $paginatedUsers = $this->userService->getPaginatedUser();

            return response()->json([
                'success' => 'Thêm người dùng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render(),
            ]);
        } catch (Exception $e) {
            Log::error('Failed to add new User: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Thêm người dùng thất bại',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $user = $this->userService->updateUser($request->all(), $id);
            Log::info('User updated successfully');
            $updateApiUrl = config('app.api_url') . '/api/update-user/' . $id;
            $client = new Client();

            $data = $request->all();
            $sub_wallet = preg_replace('/[^\d]/', '', $request->sub_wallet);
            if (empty($sub_wallet)) {
                $sub_wallet = 0;
            }
            $data['sub_wallet'] = $sub_wallet;
            Log::info($data);
            $response = $client->post($updateApiUrl, [
                'form_params' => $data,
            ]);

            if ($response->getStatusCode() != 200) {
                throw new Exception('Failed to update this user to Admin');
            } else {
                Log::info('User updated to Admin successfully');
            }

            $paginatedUsers = $this->userService->getPaginatedUser();

            return response()->json([
                'success' => 'Chỉnh sửa thông tin người dùng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render(),
            ]);
        } catch (Exception $e) {
            Log::error('Failed to update User: ' . $e->getMessage(), [
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'error' => 'Chỉnh sửa thông tin người dùng thất bại',
            ], 500);
        }
    }

    public function delete($id)
    {
        try {
            $user = $this->userService->deleteUser($id);
            Log::info('User deleted successfully');
            $deleteApiUrl = config('app.api_url') . '/api/delete-user/' . $id;
            $client = new Client();

            $response = $client->post($deleteApiUrl);

            if ($response->getStatusCode() != 200) {
                throw new Exception('Failed to delete this user in Admin');
            } else {
                Log::info('User deleted in Admin successfully');
            }

            $paginatedUsers = $this->userService->getPaginatedUser();

            return response()->json([
                'success' => 'Xóa tài khoản người dùng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render(),
            ]);
        } catch (Exception $e) {
            Log::error('Error deleting user via API: ' . $e->getMessage());

            return response()->json([
                'error' => 'Xóa thông tin người dùng thất bại'
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
        $apiURL = 'http://127.0.0.1:8001/api/update-user';
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
            $apiURL = 'http://127.0.0.1:8001/api/delete-user';
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
