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

    public function ClientProfileStore(Request $request)
    {
        $this->clientService->updateClientProfile($request);

        return redirect()->back()->with([
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function ClientPasswordUpdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!$this->clientService->changeClientPassword($request->all())) {
            return back()->with([
                'message' => 'Old Password Does Not Match!',
                'alert-type' => 'error',
            ]);
        }

        return back()->with([
            'message' => 'Password Changed Successfully',
            'alert-type' => 'success',
        ]);
    }
}
