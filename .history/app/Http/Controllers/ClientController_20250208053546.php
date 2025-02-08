<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Mail\Websitemail;
use App\Models\Client;

class ClientController extends Controller
{
    // Login Page
    public function ClientLogin(){
        return view('client.client_login');
    }

    // Dashboard
    public function ClientDashboard(){
        return view('client.index');
    }

    // Handle Client Login
    public function ClientLoginSubmit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // $data = [
        //     'email' => $check['email'],
        //     'password' => $check['password']
        // ];

        if(Auth::guard('client')->attempt($request->only('email', 'password'))){
            return redirect()->route('client.client_dashboard')->with('success', 'Login Successful');
        } else {
            return redirect()->route('client.client_login')->with('error', 'Invalid Credentials');
        }
    }

    // Logout
    public function ClientLogout(){
        Auth::guard('client')->logout();
        return redirect()->route('client.client_login')->with('success', 'Logged out successfully');
    }

    // Registration Page
    public function ClientRegister(){
        return view('client.client_register');
    }

    // Handle Client Registration
    public function ClientRegisterSubmit(Request $request){
        $request->validate([
            'name' => ['required','string','max:200'],
            'email' => ['required','string','unique:clients'],
            'password' => 'required|confirmed',
        ]);

        Client::insert([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'client',
            'status' => '0',
        ]);

        //
        $notificaion = array(
            'message' => 'Client Registered Successfully',
            'alert-type' => 'success',
        );

        return redirect()->route('client.client_login')->with('success', 'Registration successful ! Plw');
    }

    // Forget Password Page
    public function ClientForgetPassword(){
        return view('client.client_forget_password');
    }

    // Handle Password Reset Request
    public function ClientPasswordSubmit(Request $request){
        $request->validate(['email' => 'required|email']);

        $client = Client::where('email', $request->email)->first();
        if(!$client){
            return back()->with('error', 'Email Not Found');
        }

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => Hash::make($token),
            'created_at' => now(),
        ]);

        $reset_link = url('client/client_reset_password/'.$token.'/'.$request->email);
        Mail::to($request->email)->send(new Websitemail("Reset Password", "Click <a href='$reset_link'>here</a> to reset your password."));

        return back()->with('success', 'Reset Password Link Sent to Your Email');
    }

    // Reset Password Page
    public function ClientResetPassword($token, $email){
        return view('client.client_reset_password', compact('token', 'email'));
    }

    // Handle Password Reset Submission
    public function ClientResetPasswordSubmit(Request $request){
        $request->validate(['password' => 'required|confirmed']);

        $client = Client::where('email', $request->email)->first();
        if (!$client) {
            return redirect()->route('client.client_login')->with('error', 'Invalid Email');
        }

        $client->password = Hash::make($request->password);
        $client->save();

        return redirect()->route('client.client_login')->with('success', 'Password Reset Successfully');
    }

    // Profile Page
    public function ClientProfile(){
        $client = Auth::guard('client')->user();
        return view('client.client_profile', compact('client'));
    }

    // Update Profile
    public function ClientProfileStore(Request $request){
        $client = Auth::guard('client')->user();
    
        if (!$client instanceof Client) {
            return back()->with('error', 'User not found or not authenticated');
        }
    
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:clients,email,'.$client->id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);
    
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo')->store('client_images', 'public');
            $client->photo = $photo;
        }
    
        // Ensure $client is an Eloquent model instance
        if ($client instanceof Client) {
            $client->update($request->only('name', 'email', 'phone', 'address'));
        }
    
        return back()->with('success', 'Profile Updated Successfully');
    }
    

    // Change Password Page
    public function ClientChangePassword(){
        return view('client.client_change_password');
    }

    // Update Password
    public function ClientPasswordUpdate(Request $request){
        $client = Auth::guard('client')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $client->password)) {
            return back()->with('error', 'Old Password Does Not Match');
        }

        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success','Password Changed Successfully!');
    }
}
