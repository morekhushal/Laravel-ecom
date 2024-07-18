<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;
use Session;
use View;

class CartController extends Controller
{
    public function addToCart(Request $request, $productId) {
        $userId = Auth::user()->id;
        $checkExist = Cart::where(['user_id'=>$userId, 'product_id'=>$productId])->first();
        
        //If product already exists in cart, redirect to cart
        if($checkExist) {
            Session::flash('success', 'Product already placed in cart');
            return redirect()->route('carts.index');
        }
        
        $cart = new Cart();
        $cart->user_id = $userId;
        $cart->qty = 1;
        $cart->product_id = $productId;
        if($cart->save()) {
            return redirect()->route('carts.index')->withSuccess('Product has been added to cart');
        } else {
            Session::flash('error', 'Failed to add product to cart');
            return back();
        }
    }

    public function loadCart() {
        $carts = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        return view('load_cart', compact('carts'));
    }

    public function updateCartQty(Request $request) {
        $product = Product::find($request->productId);
        if($product) {
            if($request->qty > $product->qty) {
                return response()->json(['success' => false, 'message' => 'Maximum available quantity for current product is '.$product->qty]);
            } else {
                //Reducing stock
                // $product->qty -= $request->qty;
                // $product->save();

                Cart::where(['user_id'=>Auth::user()->id, 'product_id' => $request->productId])->update(['qty'=>$request->qty]);
                return response()->json(['success' => true]);
            }
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->with('product')->get();
        // echo '<pre>'; print_r($carts->toArray()); die;
        return view('cart', compact('carts'));
    }

    public function placeOrder(Request $request) {
        $userId = Auth::user()->id;
        $carts = Cart::where(['user_id' => $userId])->get();
       
        //check qty
        foreach($carts as $cart) {
            $product = Product::where('id', $cart->product_id)->where('qty', '<', $cart->qty)->first();
            if($product) {
                $error = 'insufficient qty for '.$product->title;
                Session::flash('error', $error);
                return back();
            }
        }

        //Place orders
        foreach($carts as $cart) {
            $product = Product::find($cart->product_id);
            $cart = Cart::find($cart->id);
            if($product) {
                $order = new Order();
                $order->user_id = $userId;
                $order->name = Auth::user()->name;
                $order->product_id = $product->id;
                $order->product_title = $product->title;
                $order->product_price = $product->price;
                $order->qty = $cart->qty;
                $order->save();

                //remove cart
                $cart->delete();

                //decrease qty from product
                $product->decrement('qty', $cart->qty);

            }            
        }        
        return redirect()->route('carts.index')->withSuccess('Order has been plaed successfully');

    }

    public function removeCart(Request $request) {
        $cart = Cart::find($request->cartId);
        if($cart->delete()) {
            return response()->json(['success' => true, 'message' => 'Cart removed']);  
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to remove product from cart']);
        }
    }
    public function destroy(Cart $cart)
    {
        if($cart->delete()) {
            return redirect()->route('carts.index')->withSuccess('Product has been removed from cart');
        } else {
            Session::flash('error', 'Failed to remove product from cart');
            return back();
        }
    }
}
