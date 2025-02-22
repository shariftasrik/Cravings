<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function AdminLogin()
    {
        return view('admin.login');
    }

    public function AdminDashboard()
    {
        return view('admin.index');
    }

    public function AdminLoginSubmit(Request $request)
    {
        return $this->adminService->loginSubmit($request);
    }

    public function AdminLogout()
    {
        return $this->adminService->logout();
    }

    public function AdminForgetPassword()
    {
        return view('admin.forget_password');
    }

    public function AdminPasswordSubmit(Request $request)
    {
        return $this->adminService->forgetPassword($request);
    }

    public function AdminResetPassword($token, $email)
    {
        return $this->adminService->resetPassword($token, $email);
    }

    public function AdminResetPasswordSubmit(Request $request)
    {
        return $this->adminService->resetPasswordSubmit($request);
    }

    public function AdminProfile()
    {
        $profileData = $this->adminService->getProfile();
        return view('admin.admin_profile', compact('profileData'));
    }

    public function AdminProfileStore(Request $request)
    {
        return $this->adminService->updateProfile($request);
    }

    public function AdminChangePassword()
    {
        $profileData = $this->adminService->getProfile();
        return view('admin.admin_change_Password', compact('profileData'));
    }

    public function AdminPasswordUpdate(Request $request)
    {
        $adminId = Auth::guard('admin')->id();
        return $this->adminService->changePassword($adminId, $request->all());
    }
}
