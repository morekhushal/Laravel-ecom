<?php

namespace App\Http\Controllers;

    use Illuminate\Http\Request;
use Auth;
use Session;
use App\Models\Product; 

class UserController extends Controller
{
    public function login(Request $request) {
        if($request->isMethod('get')) {
            return view('user_login');
        } else {
            $validate = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            // return $request->all();
            if (Auth::attempt(['email' => $validate['email'], 'password' => $validate['password']])) {
                return redirect('user-home');
            } else {
                Session::flash('error', 'Invalid Email or Password');
                return back();
            }
        }
    }
    public function userHome() {
        $products = Product::get();
        return view('user_home', compact('products'));
    }

    

    public function userLogout() {
        Auth::logout();
        return redirect('/');
    }
}

