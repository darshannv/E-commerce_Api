<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('variants')->latest()->get();

        return response()->json($products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'variants' => 'required|array',
            '*.variants.*.name' => 'required',
            '*.variants.*.sku' => 'required',
            '*.variants.*.additional_cost' => 'required|numeric',
            '*.variants.*.stock_count' => 'required|integer'

        ]);

        //dd($request->all());

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price     
        ]);


        $variants = [];
        foreach($request->input('variants') as $variant){
            $variants[] = new Variant($variant); 
        }

        $product->variants()->saveMany($variants);

        return response()->json($product, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $detail = Product::with('variants')->findOrFail($product->id);
        //dd($detail);

        return response()->json($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $detail = Product::with('variants')->findOrFail($product->id);
        return response()->json($detail);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'variants' => 'required|array',
            '*.variants.*.name' => 'required',
            '*.variants.*.sku' => 'required',
            '*.variants.*.additional_cost' => 'required|numeric',
            '*.variants.*.stock_count' => 'required|integer'

        ]);
       // 
        $product = Product::findOrFail($product->id);
       
        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price     
        ]);

        $variants = [];
        foreach($request->input('variants') as $variant){
            if(isset($variant['id'])){
                $variant_data = Variant::findOrFail($variant['id']);
                $variant_data->update($variant);
                $variants[] = $variant;
            } else {
                $variants[] = new Variant($variant);
            }
             
        }


        $product->variants()->delete();
        $product->variants()->saveMany($variants);


        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $detail = Product::findOrFail($product->id);
        $detail->delete();
        return response()->json(null, 204);
    }


    public function search($query){

        
        //dd($query);
        $products = Product::where('name', 'like', "%{$query}%")
                ->orWhere('description', 'like', "%{$query}%")
                ->orWhereHas('variants', function($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%");
                })
                ->with('variants')->get();

        return response()->json($products);
    }
}
