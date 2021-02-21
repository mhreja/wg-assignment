<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use Storage;

class ProductController extends Controller
{
    public function index(){
        $users = User::all();
        return view('products.index', compact('users'));
    }

    public function getproducts(){
        $data = Product::join('users', 'products.user_id', '=', 'users.id')->select('products.*', 'users.name', 'users.email')->latest()->get();
        return $data;
    }

    public function store(Request $request){
        $request->validate([
            'user_id'=>['required', 'integer'],
            'product_name'=>['required', 'string', 'max:255'],
            'product_desc'=>['required', 'string'],
            'image'=>['required', 'image', 'mimes:jpg,jpeg,png', 'max:500']
        ]);

        if($request->has('image')){
            $request->file('image')->store('public/products');
            $request->merge(['product_image' => $request->image->hashName()]);
        }

        Product::create($request->all());
        $data = ['success'=>true, 'message'=>'Product Added'];
        return $data;

    }

    public function update(Request $request, Product $product){
        $request->validate([
            'product_name'=>['required', 'string', 'max:255'],
            'product_desc'=>['required', 'string'],
            'image'=>['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:500']
        ]);

        if ($request->has('image')) {
            $old_path = Product::where('id',$product->id)->pluck('product_image')->first();
            Storage::delete('public/products/'.$old_path);

            $request->file('image')->store('public/products');
            $request->merge(['product_image' => $request->image->hashName()]);
        }

        $product->update($request->all());
        $data = ['success'=>true, 'message'=>'Product details updated'];
        return $data;
    }

    public function delete($id){
        $old_path = Product::where('id',$id)->pluck('product_image')->first();
        Storage::delete('public/products/'.$old_path);

        Product::find($id)->delete();
    	return ['success'=>true, 'message'=>'Product Deleted.'];
    }


    public function filterbydate(Request $request){
        $request->validate([
    		'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
        ]);

        $data = Product::whereDate('products.created_at', '>=', $request->start_date)
            ->whereDate('products.created_at', '<=', $request->end_date)
            ->join('users', 'products.user_id', '=', 'users.id')
            ->select('products.*', 'users.name', 'users.email')
        ->latest()->get();
        
        return $data;
    }
}