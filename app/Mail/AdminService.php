<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Websitemail;
use App\Models\Admin;

class AdminService
{
    public function loginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {
            return redirect()->route('admin.dashboard')->with('success', 'Login Successfully');
        }

        return redirect()->route('admin.login')->with('error', 'Invalid Credentials');
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success', 'Logout Successfully');
    }

    public function forgetPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $admin = Admin::where('email', $request->email)->first();

        if (!$admin) {
            return redirect()->back()->with('error', 'Email Not Found');
        }

        $token = hash('sha256', time());
        $admin->token = $token;
        $admin->save();

        $reset_link = url('admin/reset_password/' . $token . '/' . $request->email);
        $subject = "Reset Password";
        $message = "Click the link below to reset your password: <br>";
        $message .= "<a href='" . $reset_link . "'>Reset Password</a>";

        Mail::to($request->email)->send(new Websitemail($subject, $message));

        return redirect()->back()->with('success', 'Reset Password Link Sent To Your Email');
    }

    public function resetPassword($token, $email)
    {
        $admin = Admin::where('email', $email)->where('token', $token)->first();

        if (!$admin) {
            return redirect()->route('admin.login')->with('error', 'Invalid Token or Email');
        }

        return view('admin.reset_password', compact('token', 'email'));
    }

    public function resetPasswordSubmit(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin = Admin::where('email', $request->email)->where('token', $request->token)->first();
        $admin->password = Hash::make($request->password);
        $admin->token = "";
        $admin->save();

        return redirect()->route('admin.login')->with('success', 'Password Reset Successfully');
    }

    public function getProfile()
    {
        $id = Auth::guard('admin')->id();
        return Admin::find($id);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::guard('admin')->id();
        $admin = Admin::find($id);

        $admin->name = $request->name;
        $admin->email = $request->email;
        $admin->phone = $request->phone;
        $admin->address = $request->address;
        $oldPhotoPath = $admin->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('upload/admin_images'), $filename);
            $admin->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profile Updated Successfully');
    }

    private function deleteOldImage(string $oldPhotoPath): void
    {
        $fullPath = public_path('upload/admin_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function changePassword($adminId, array $data)
{
    $admin = Admin::find($adminId); 

    if (!$admin) {
        throw new \Exception("Admin not found for ID: $adminId");
    }

    if (!Hash::check($data['old_password'], $admin->password)) {
        return redirect()->back()->with('error', 'Old Password Does Not Match');
    }

    $admin->password = Hash::make($data['new_password']);

    if (!$admin->save()) {
        throw new \Exception("Failed to update password.");
    }

    return redirect()->back()->with('success', 'Password Changed Successfully');
}

}
