<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Spatie\Translatable\HasTranslations;

class ProductController extends Controller
{
    use HasTranslations;
  
    public function index(Request $request)
    {
        // $all_products=Product::all();
        // return response()->json($all_products,200);

        $products=Product::with('sub_category')->paginate(3);
        if($request->has('name')){
            $products=Product::with('sub_category')->where('name',$request->name)->get();
        }
        if($request->has('price')){
            $products=Product::with('sub_category')->where('price','<=',$request->price)->get();
        }
        if($request->has('sub_category_id')){
            $products=Product::with('sub_category')->where('sub_category_id',$request->sub_category_id)->get();
        }
        if($request->has('brand_id')){
            $products=Product::with('brand')->where('brand_id','<=',$request->brand_id)->get();
        }
        return response()->json($products,200);
    }

    public function store(ProductRequest $request)
    {
        $validated_data=$request->validated();
        $product=Product::create($validated_data);
        return response()->json($product, 201);
    }

    public function show(int $id)
    {
        try{
            //$product=Product::find($id);
            $product=Product::with('sub_category')->find($id);
            return response()->json($product, 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Product Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(ProductRequest $request, int $id)
    {
        try{
            $product=Product::find($id);
            $product->update($request->validated());
            return response()->json($product, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Product Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try{
            $product=Product::find($id);
            $product->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Product Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
