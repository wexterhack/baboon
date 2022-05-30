<?php

namespace App\Http\Controllers\Auth\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function posts($id){

    }
    public function profile(Request $request, $id){
        return view('auth.users.profile');
    }
}
