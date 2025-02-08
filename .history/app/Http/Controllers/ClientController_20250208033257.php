<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Websitemail;
use App\Models\Client;

class ClientController extends Controller
{
    public function ClientLogin(){
        return view('client.client_login');
    }

    public function ClientDashboard(){
        return view('client.client_dashboard');
    }

    public function ClientLoginSubmit(Request $request){
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if(Auth::guard('client')->attempt($data)){
            return redirect()->route('client.dashboard')->with('success','Login Successful');
        } else {
            return redirect()->route('client.login')->with('error','Invalid Credentials');
        }
    }

    public function ClientLogout(){
        Auth::guard('client')->logout();
        return redirect()->route('client.login')->with('success','Logged out successfully');
    }

    public function ClientForgetPassword(){
        return view('client.client_forget_password');
    }

    public function ClientPasswordSubmit(Request $request){
        $request->validate(['email' => 'required|email']);

        $client_data = Client::where('email', $request->email)->first();
        if(!$client_data){
            return redirect()->back()->with('error','Email Not Found');
        }

        $token = hash('sha256', time());
        $client_data->token = $token;
        $client_data->update();

        $reset_link = url('client/reset_password/'.$token.'/'.$request->email);
        $subject = "Reset Password";
        $message = "Click the link below to reset your password<br>";
        $message .= "<a href='".$reset_link." '> Reset Password </a>";

        Mail::to($request->email)->send(new Websitemail($subject, $message));
        return redirect()->back()->with('success','Reset Password Link Sent to Your Email');
    }

    public function ClientResetPassword($token, $email){
        $client_data = Client::where('email', $email)->where('token', $token)->first();
        if(!$client_data){
            return redirect()->route('client.login')->with('error','Invalid Token or Email');
        }
        return view('client.client_reset_password', compact('token', 'email'));
    }

    public function ClientResetPasswordSubmit(Request $request){
        $request->validate([
            'password' => 'required|confirmed',
        ]);

        $client_data = Client::where('email', $request->email)->where('token', $request->token)->first();
        $client_data->password = Hash::make($request->password);
        $client_data->token = "";
        $client_data->update();

        return redirect()->route('client.login')->with('success','Password Reset Successfully');
    }

    public function ClientProfile(){
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_profile', compact('profileData'));
    }

    public function ClientProfileStore(Request $request){
        $id = Auth::guard('client')->id();
        $data = Client::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->move(public_path('upload/client_images'), $filename);
            $data->photo = $filename;

            if ($oldPhotoPath && $oldPhotoPath !== $filename) {
                $this->deleteOldImage($oldPhotoPath);
            }
        }

        $data->save();
        return redirect()->back()->with('success','Profile Updated Successfully');
    }

    private function deleteOldImage(string $oldPhotoPath): void{
        $fullPath = public_path('upload/client_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }

    public function ClientChangePassword(){
        return view('client.client_change_password');
    }

    public function ClientPasswordUpdate(Request $request){
        $client = Auth::guard('client')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, $client->password)) {
            return back()->with('error','Old Password Does not Match!');
        }

        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success','Password Changed Successfully!');
    }
}
