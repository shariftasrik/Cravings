<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function CliLogin(){
        return view('admin.login');
    }
    // End Method
}
