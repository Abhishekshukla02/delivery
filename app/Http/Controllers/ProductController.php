<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ProductController extends Controller
{
    
    public function showAllProducts()
    {
        return response()->json(Product::all());
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'barcode' => 'required|unique:products',
            'cost' =>  'required|numeric',
            'vat_class' =>  'required|numeric' 
        ]);

        $product = Product::create($request->all());

        return response()->json($product, 201);
    }

    public function getProduct(Request $request) 
    {    
        $barcode = $request->query('barcode');
        $product = Product::where('barcode',$barcode)->first();
        return response()->json($product, 200);   
    }
}
