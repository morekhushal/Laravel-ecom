<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Order;
use Auth;
use Session;
use App\Models\Product; 

class AdminController extends Controller
{
    public function login(Request $request) {
        if($request->isMethod('get')) {
            return view('admin/admin_login');
        } else {
            $validate = $request->validate([
                'email' => 'required|email',
                'password' => 'required',
            ]);
            // return $request->all();
            if (Auth::guard('admin')->attempt(['email' => $validate['email'], 'password' => $validate['password']])) {
                return redirect()->route('orders');
            } else {
                Session::flash('error', 'Invalid Email or Password');
                return back();
            }
        }
    }

    public function adminHome() {
        $products = Product::get();
        return view('admin.admin_home', compact('products'));
    }

    public function orders() {
        $orders = Order::all();
        return view('admin.orders', compact('orders'));
    }

    public function loadOrders() {
        $orders = Order::all();
        return view('admin.load_orders', compact('orders'));
    }

    public function adminLogout() {
        Auth::guard('admin')->logout();
        return redirect('/');
    }
}
