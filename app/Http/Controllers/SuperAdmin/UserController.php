<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\User;
use App\Services\UserService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|numeric|digits:10|unique:users,phone',
            'address' => 'required|string|max:255',
            'field' => 'nullable|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'tax_code' => 'nullable|numeric',
            'username' => 'required|unique:users,username',
            'sub_wallet' => 'nullable'
        ], [
            'name.required' => 'Tên không được trống',
            'name.max' => 'Tên không được quá :max ký tự',
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
            'address.required' => 'Vui lòng điền địa chỉ khách hàng'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'validation_errors' => $validator->errors()
            ]);
        }
        try {
            // Thêm người dùng mới
            //$newUser = $this->userService->addNewUser($request->all());

            //Gửi request tới API của Admin
            $adminApiUrl = 'https://127.0.0.1:8001/api/add-user';
            $client = new Client();

            $data = $request->all();

            $password = '123456';
            $hashedPassword = Hash::make($password);
            $sub_wallet = preg_replace('/[^\d]/', '', $request->sub_wallet);
            $data['role_id'] = 1; // Thêm role_id vào dữ liệu gửi đi
            $data['password'] = $hashedPassword;
            $sub_wallet = preg_replace('/[^\d]/', '', $request->sub_wallet);
            if (empty($sub_wallet)) {
                $sub_wallet = 0; // Giá trị mặc định là 0 nếu không có giá trị
            }
            $data['sub_wallet'] = $sub_wallet;
            // $data['']
            Log::info($data);
            $response = $client->post($adminApiUrl, [
                'form_params' => $data,
                'verify' => false, // Bỏ qua xác thực SSL cho môi trường cục bộ
            ]);

            // Kiểm tra phản hồi từ API Admin
            if ($response->getStatusCode() !== 200) {
                throw new Exception('Failed to add user to Admin');
                return response()->json(['error' => 'Thêm người dùng vào Admin không thành công'], 500);
            }

            // Lấy danh sách người dùng đã phân trang
            $paginatedUsers = $this->userService->getPaginatedUser();

            return response()->json([
                'success' => 'Thêm khách hàng thành công',
                'html' => view('superadmin.user.table', ['users' => $paginatedUsers])->render(),
                'pagination' => $paginatedUsers->links('pagination::custom')->render(),
            ]);
        } catch (Exception $e) {
            // Ghi log chi tiết hơn về lỗi
            Log::error('Failed to add new User: ' . $e->getMessage(), [
                'request_data' => $request->all()
            ]);

            return response()->json([
                'error' => 'Thêm khách hàng không thành công'
            ], 500);
        }
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        return response()->json($user);
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
            'sub_wallet' => 'nullable'
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
            'address.required' => 'Vui lòng điền địa chỉ khách hàng'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'error' => true,
                'validation_errors' => $validator->errors()
            ]);
        }
        $apiURL = 'http://127.0.0.1:8001/api/update-user';
        $response = Http::post($apiURL, $request->all());
        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to update user to Admin');
            return response()->json(['error' => 'Cập nhật người dùng vào Admin không thành công'], 500);
        }
        $newUser = $this->userService->updateUser($request->all());
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
            $apiURL = 'http://127.0.0.1:8001/api/delete-user';
            $response = Http::delete($apiURL, [
                'user_id' => $request->id
            ]);
            if (!$response->successful()) {
                return response()->json([
                    'error' => 'Xóa người dùng không thành công ở phía API'
                ], $response->status());
            }
            $this->userService->deleteUserById($id);
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
