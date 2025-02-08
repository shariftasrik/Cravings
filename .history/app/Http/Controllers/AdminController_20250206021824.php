<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Contracts\Service\Attribute\Required;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Mail;
use App\Mail\Websitemail;
use App\Models\Admin;

class AdminController extends Controller
{
    public function AdminLogin(){
        return view('admin.login');
    }
    // End Method

    public function AdminDashboard(){
        return view('admin.index');
    }
    // End Method

    public function AdminLoginSubmit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $check = $request->all();

        $data = [
            'email' => $check['email'],
            'password' => $check['password']
        ];

        if(Auth::guard('admin')->attempt($data)){
            return redirect()->route('admin.dashboard')->with('success',
            'Login Successfully');
        }else{
            return redirect()->route('admin.login')->with('error',
            'Invalid Credentials');
        }
    }
    //End Method

    public function AdminLogout(){
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login')->with('success',
        'Logout Successfully');
    }
    //End Method


    public function AdminForgetPassword(){
        return view('admin.forget_password');
    }
    //End Method


    public function AdminPasswordSubmit(Request $request){
        $request->validate([
            'email' => 'required|email',
        ]);

        $admin_data = Admin::where('email',$request->email)->first();

        if(!$admin_data){
            return redirect()->back()->with('error','Email Not Found');
        }

        $token = hash('sha256', time());
        $admin_data->token= $token;
        $admin_data->update();


        $reset_link = url('admin/reset_password/'.$token.'/'.$request->email);
        $subject = "Reset Password";
        $message = "Please Click on below link to reset password<br>";
        $message .= "<a href='".$reset_link." '> Click Here </a>";


        Mail::to($request->email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success','Reset Password Link Send On Your Mail');

    }
    //End Method

    public function AdminResetPassword($token,$email){

        $admin_data = Admin::where('email',$email)->where('token',$token)->first();

        if(!$admin_data){
            return redirect()->route('admin.login')->with('error','Invalid Token or Email');
        }

        return view('admin.reset_password',compact('token','email'));

    }
    //End Method

    public function AdminResetPasswordSubmit(Request $request){
        $request->validate([
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        $admin_data = Admin::where('email',$request->email)->where('token',$request->token)->first();
        $admin_data->password = Hash::make($request->password);
        $admin_data->token = "";
        $admin_data->update();


        return redirect()->route('admin.login')->with('success','Reset Password Successfully');

    }
    //End Method

    public function AdminProfile(){
        $id = Auth::guard('admin')->id();
        $profileData = Admin::find($id);
        return view('admin.admin_profile', compact('profileData'));
    }
    //End Method


    public function AdminProfileStore(Request $request){
        $id = Auth::guard('admin')->id();
        $data = Admin::find($id);
        
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $oldPhotoPath = $data->photo;
        
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');

            //generate file name of the inserted photo for admin
            $filename = time().'.'.$file-> getClientOriginalExtension();

            // photo upload hbe puclic/upload/admin_images folder e
            $file->move(public_path('upload/admin_images'), $filename);
            $data-> photo = $filename;

            // folder theke ager chobi soraiye new chobi rakha
            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }        
        

        $data->save();

        return redirect()->back();
    }
    //End Method

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/admin_images/');

        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
    // End Method

}
