<?php

namespace App\Services;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ClientService
{
    public function registerClient(array $data)
    {
        return Client::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'password' => Hash::make($data['password']),
            'role' => 'client',
            'status' => '0',
        ]);
    }

    public function loginClient(array $credentials)
    {
        return Auth::guard('client')->attempt($credentials);
    }

    public function logoutClient()
    {
        Auth::guard('client')->logout();
    }

    public function getClientProfile()
    {
        return Client::find(Auth::guard('client')->id());
    }

    public function updateClientProfile(Request $request)
    {
        $client = Client::find(Auth::guard('client')->id());
    
        if (!$client) {
            return null; 
        }
    
        $client->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
    
        if ($request->hasFile('photo')) {
            $client->photo = $this->uploadImage($request->file('photo'), 'photo', $client->photo);
        }
    
        if ($request->hasFile('cover_photo')) {
            $client->cover_photo = $this->uploadImage($request->file('cover_photo'), 'cover_photo', $client->cover_photo);
        }
    
        $client->save();
    
        return $client;
    }
    

    public function changeClientPassword(array $data)
    {
        $client = Auth::guard('client')->user();
    
        if (!$client instanceof Client || !Hash::check($data['old_password'], $client->password)) {
            return false; 
        }
    
        $client->password = Hash::make($data['new_password']);
        $client->save(); 
    
        return true;
    }
    
    

    private function uploadImage($file, $type, $oldFile = null)
    {
        $filename = time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('upload/client_images'), $filename);

        if ($oldFile) {
            $this->deleteOldImage($oldFile);
        }

        return $filename;
    }

    private function deleteOldImage($oldPhotoPath)
    {
        $fullPath = public_path('upload/client_images/' . $oldPhotoPath);
        if (file_exists($fullPath)) {
            unlink($fullPath);
        }
    }
}
