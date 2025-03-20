<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function getBanner()
    {
        $banners = SuperAdmin::select('banner')->firstOrFail();
        return $banners;
    }
}
