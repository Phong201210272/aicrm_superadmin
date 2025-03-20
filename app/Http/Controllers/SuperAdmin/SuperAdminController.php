<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Http\Responses\ApiResponse;
use App\Models\Bank;
use App\Models\SuperAdmin;
use App\Services\AdminService;
use App\Services\SupperAdminService;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SuperAdminController extends Controller
{
    protected $adminService;
    protected $supperAdminService;

    public function __construct(AdminService $adminService, SupperAdminService $supperAdminService)
    {
        $this->adminService = $adminService;
        $this->supperAdminService = $supperAdminService;
    }

    public function getSuperAdminInfor($id)
    {
        try {
            $bank = Bank::get();
            $sa = $this->adminService->getSuperAdminById($id);

            // Giải mã dữ liệu JSON từ cột banner
            $banner = json_decode($sa->banner);
            $banner = collect($banner)->map(function ($item, $index) {
                return [
                    'id' => $index + 1,
                    'src' => $item,
                ];
            });
            return view('superadmin.profile.detail', compact('sa', 'bank', 'banner'));
        } catch (Exception $e) {
            Log::error('Failed to fetch super admin info: ' . $e->getMessage());
            return ApiResponse::error('Failed to fetch super admin info', 500);
        }
    }

    public function updateSuperAdminInfo(Request $request, $id)
    {
<<<<<<< HEAD
        // dd($request->all());
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^((03|05|07|08|09)+([0-9]{8}))$/', 'unique:super_admins,phone,' . $id],
            'email' => 'required|email|unique:users,email,' . $id,
            'bank_id' => 'nullable',
            'bank_account' => 'nullable',
            'company_bank_account' => 'nullable',
            'company_bank_id' => 'nullable',
            'company_name' => 'nullable',

=======
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => ['required', 'regex:/^((03|05|07|08|09)+([0-9]{8}))$/', 'unique:super_admins,phone,' . $id],
            'email' => 'required|email|unique:users,email,' . $id,
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
        ], [
            'name.required' => 'Tên không được để trống.',
            'name.string' => 'Tên phải là chuỗi ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex' => 'Số điện thoại không đúng định dạng Việt Nam (bắt đầu bằng 03, 05, 07, 08, hoặc 09 và có 10 chữ số).',
            'phone.unique' => 'Số điện thoại này đã tồn tại.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email phải là một địa chỉ email hợp lệ.',
            'email.unique' => 'Email này đã tồn tại.',
        ]);
<<<<<<< HEAD

        //  dd($validated);

        try {
            $sa = SuperAdmin::findOrFail($id);
=======
        try {
            Log::info($request->all());
            $apiUrlSuperAdminUpdate = 'http://127.0.0.1:8001/api/update/super_admin';
            $response = Http::post($apiUrlSuperAdminUpdate, $request->all());
            if (!$response->successful()) {
                session()->flash('error', 'Thay đổi thông tin không thành công');
                return redirect()->back();
            }
            $sa = $this->adminService->updateSuperAdmin($id, $request->all());
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            // dd($sa);

            // Kiểm tra và xử lý banner cũ
            if (is_array($request->old)) {
                foreach (json_decode($sa->banner) ?? [] as $key => $item) {
                    if (isset($request->old[$key])) {
                        $validated['banner'][] = $item;
                    } else {
                        deleteImage($item);
                    }
                }
            }

            // Xử lý ảnh mới
            if ($request->hasFile('banner')) {
                $newImages = saveImages($request, 'banner', 'banners', true);
                $validated['banner'] = array_merge($validated['banner'] ?? [], $newImages);
            }

            // Cập nhật thông tin
            $sa->update($validated);
            Log::info('Super admin updated successfully, start updating in Admin');

            $validated['id'] = $id;
            // Cập nhật thông tin người dùng trong session
            $authUser = session('authSuper');
            $authUser->name = $sa->name;
<<<<<<< HEAD
            $authUser->email = $sa->email;
=======
            // dd($authUser->name);
            $authUser->email =  $sa->email;
            // dd($authUser->email);
            // $authUser->user_info->img_url = $sa->user_info->img_url;
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            session(['authSuper' => $authUser]);
            $updateSuperAdminApiUrl = config('app.api_url') . '/api/update-super-admin';
            $client = new Client();
            $response = $client->post($updateSuperAdminApiUrl, [
                'form_params' => $validated,
            ]);

            if ($response->getStatusCode() !== 200) {
                Log::error('SuperAdmin updated failed');
                throw new Exception('Failed to update superadmin in admin');
            } else {
                Log::info('SuperAdmin updated successfully');
            }
            Log::info('Successfully updated super admin profile');
            session()->flash('success', 'Thay đổi thông tin thành công');
            return redirect()->back();
        } catch (Exception $e) {
            Log::error('Failed to update admin info: ' . $e->getMessage());
            return ApiResponse::error('Failed to update admin info', 500);
        }
    }

    public function loginForm()
    {
        return view('superadmin.formlogin.index');
    }

    public function login(Request $request)
    {
        try {
            $credentials = $request->only(['email', 'password']);
            $result = $this->supperAdminService->authenticateSupper($credentials);
            session()->put('authSuper', $result['supper']);
            return redirect()->route('super.user.index');
        } catch (Exception $e) {
            Log::error('Failed to login: ' . $e->getMessage());
            return $this->handleLoginError($request, $e);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->flush();
        return redirect()->route('super.dang.nhap');
    }
    protected function handleLoginError($request, \Exception $e)
    {
        return redirect()->back()->withErrors(['error' => $e->getMessage()]);
    }
}
