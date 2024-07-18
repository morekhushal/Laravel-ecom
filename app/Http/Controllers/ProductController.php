<?php

namespace App\Http\Controllers;

use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::get();
        return view('admin.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric'
        ]);
        
        if (Product::create($validate)) {
            return redirect('products')->withSuccess('Product has been created successfully');
        } else {
            Session::flash('error', 'Failed to create product');
            return back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required',
            'qty' => 'required|numeric',
            'price' => 'required|numeric'
        ]);

        $product->title = $request->title;
        $product->qty = $request->qty;
        $product->price = $request->price;
        
        if ($product->save()) {
            return redirect('products')->withSuccess('Product has been updated successfully');
        } else {
            Session::flash('error', 'Failed to update product');
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->delete()) {
            return redirect('products')->withSuccess('Product has been deleted successfully');
        } else {
            Session::flash('error', 'Failed to delete product');
            return back();
        }
    }
}
