<?php

namespace App\Services;

use App\Mail\UserRegistered;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;


class UserService
{
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function getPaginatedUser()
    {
        try {
            return $this->user->where('role_id', 1)->orderByDesc('created_at')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to get paginated user list: ' . $e->getMessage());
            throw new Exception('Failed to get paginated user list');
        }
    }

    public function getAllUser($role)
    {
        try {
            $user = $this->user->orderByDesc('created_at')->get();
            return $user;
        } catch (Exception $e) {
            Log::error("Failed to search products: {$e->getMessage()}");
            throw new Exception('Failed to search products');
        }
    }

    public function  addNewUser(array $data)
    {
        // dd($data);
        DB::beginTransaction();
        $password = '123456';
        $hashedPassword = Hash::make($password);
        $sub_wallet = preg_replace('/[^\d]/', '', $data['sub_wallet']);
<<<<<<< HEAD
        $wallet = preg_replace('/[^\d]/', '', $data['wallet']);
        $username = strtolower($data['prefix']);
        if (empty($wallet)) {
            $wallet = 0;
        }
=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
        if (empty($sub_wallet)) {
            $sub_wallet = 0;
        }
        try {
            Log::info('Creating new user');
            $user = $this->user->create([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_name' => $data['company_name'],
                'tax_code' => $data['tax_code'],
                'address' => $data['address'],
<<<<<<< HEAD
                'expired_at' => Carbon::now()->addMonths(6),
=======
                'expired_at' => $data['expired_at'],
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
                'field' => $data['field'],
                'username' => $username,
                'role_id' => 1,
                'password' => $hashedPassword,
                'sub_wallet' => $sub_wallet ?? 0,
                'prefix' => $data['prefix'],
<<<<<<< HEAD
                'wallet' => $wallet,
=======
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            ]);
            Mail::to($data['email'])->send(new UserRegistered($user, $password));
            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to add new user: ' . $e->getMessage());
            throw new Exception('Failed to add new user');
        }
    }
<<<<<<< HEAD
    public function updateUser(array $data, $id)
=======
    public function updateUser(array $data)
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
    {
        DB::beginTransaction();
        try {
            Log::info('Updating user');
<<<<<<< HEAD
            $user = $this->user->findOrFail($id);
=======
            $user = $this->user->where('phone', $data['phone'])->first();
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            if (!$user) {
                throw new Exception('User not found');
            }
            $user->update([
                'name' => $data['name'],
                'phone' => $data['phone'],
                'email' => $data['email'],
                'company_name' => $data['company_name'],
                'tax_code' => $data['tax_code'],
                'address' => $data['address'],
                'field' => $data['field'],
<<<<<<< HEAD
                'sub_wallet' => $sub_wallet ?? 0,
                'prefix' => $data['prefix'],
            ]);
            DB::commit();
            Log::info('user updated successfully');
=======
                'username' => $data['username'],
                'expired_at' => $data['expired_at']
            ]);
            DB::commit();
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Failed to update user: ' . $e->getMessage());
            throw new Exception('Failed to update user');
        }
    }

    public function getUserByPhone($phone)
    {
        try {
            return $this->user->where('phone', 'LIKE', '%' . $phone . '%')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to find this client by phone: ' . $e->getMessage());
            throw new Exception('Failed to find this client by phone');
        }
    }

    public function getUserByName($name)
    {
        try {
            return $this->user->where('name', 'LIKE', '%' . $name . '%')->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to find this client by name: ' . $e->getMessage());
            throw new Exception('Failed to find this client by name');
        }
    }
    public function deleteUserByPhone($phone)
    {
        try {
            return $this->user->where('phone', $phone)->firstOrFail()->delete();
        } catch (Exception $e) {
            Log::error('Failed to delete client by phone: ' . $e->getMessage());
            throw new Exception('Failed to delete client by phone');
        }
    }
<<<<<<< HEAD
    public function deleteUser($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return $user;
=======
    public function deleteUserById($id)
    {
        try {
            return $this->user->findOrFail($id)->delete();
>>>>>>> 0d6658eae0575da3f06b35dd224ccc62429babbf
        } catch (Exception $e) {
            Log::error('Failed to delete this client by name: ' . $e->getMessage());
            throw new Exception('Failed to delete this client by name');
        }
    }
    public function authenticateUser($credentials)
    {
        // dd($credentials);
        $user = User::where('email', $credentials['email'])->orwhere('phone', $credentials['email'])->first();
        if (!$user) {
            throw new Exception('Not an User');
        }
        $userRoleId = $user->role_id;
        if ($userRoleId != 1 && $userRoleId != 2 && $userRoleId != 3) {
            throw new Exception('Not authorized');
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            Log::warning('Unauthorized login attempt', ['user' => $user]);
            throw new Exception('Unauthorized');
        }
        Auth::login($user);
        // dd($user);
        return ['user' => $user];
    }

    public function logout(Request $request)
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login');
    }

    public function getQualifiedUsers()
    {
        try {
            return $this->user->orderBy('name', 'asc')
                ->paginate(10);
        } catch (Exception $e) {
            Log::error('Failed to get qualified users: ' . $e->getMessage());
            throw new Exception('Failed to get qualified users');
        }
    }
}
