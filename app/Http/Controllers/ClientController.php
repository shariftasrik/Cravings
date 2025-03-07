<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; 
use App\Models\Client;
use App\Services\ClientService;

class ClientController extends Controller
{
    protected $clientService;

    public function __construct(ClientService $clientService)
    {
        $this->clientService = $clientService;
    }

    public function ClientRegister()
    {
        return view('client.client_register');
    }

    public function ClientLogin()
    {
        return view('client.client_login');
    }

    public function ClientDashboard()
    {
        return view('client.index');
    }
    public function ClientRegisterSubmit(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:200'],
            'email' => ['required', 'string', 'unique:clients'],
            'password' => ['required', 'confirmed'],
        ]);

        $this->clientService->registerClient($request->all());

        return redirect()->route('client.login')->with([
            'message' => 'Client Registered Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function ClientLoginSubmit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($this->clientService->loginClient($request->only('email', 'password'))) {
            return redirect()->route('client.dashboard')->with('success', 'Login Successfully');
        }

        return redirect()->route('client.login')->with('error', 'Invalid Credentials');
    }

    public function ClientLogout()
    {
        $this->clientService->logoutClient();

        return redirect()->route('client.login')->with('success', 'Logout Successful');
    }

    public function ClientProfile()
    {
        $profileData = $this->clientService->getClientProfile();

        return view('client.client_profile', compact('profileData'));
    }

    public function ClientProfileStore(Request $request){
        $id = Auth::guard('client')->id();
        $data = Client::find($id);

        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->city_id = $request->city_id;
        $data->shop_info = $request->shop_info; 

        $oldPhotoPath = $data->photo;

        if ($request->hasFile('photo')) {
           $file = $request->file('photo');
           $filename = time().'.'.$file->getClientOriginalExtension();
           $file->move(public_path('upload/client_images'),$filename);
           $data->photo = $filename;

           if ($oldPhotoPath && $oldPhotoPath !== $filename) {
             $this->deleteOldImage($oldPhotoPath);
           }

        }

        if ($request->hasFile('cover_photo')) {
            $file1 = $request->file('cover_photo');
            $filename1 = time().'.'.$file1->getClientOriginalExtension();
            $file1->move(public_path('upload/client_images'),$filename1);
            $data->cover_photo = $filename1; 
         }

        $data->save();

        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);
    }

    private function deleteOldImage(string $oldPhotoPath): void {
        $fullPath = public_path('upload/client_images/'.$oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
     }

     public function ClientChangePassword(){
        $id = Auth::guard('client')->id();
        $profileData = Client::find($id);
        return view('client.client_change_Password',compact('profileData'));
     }
      // End Method 

      public function ClientPasswordUpdate(Request $request){
        $client = Auth::guard('client')->user();
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed'
        ]);
 
        if (!Hash::check($request->old_password,$client->password)) {
            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }
        /// Update the new password 
        Client::whereId($client->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

                $notification = array(
                'message' => 'Password Change Successfully',
                'alert-type' => 'success'
            );
            return back()->with($notification);
     }
      // End Method 
}
