<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_brands=Brand::all();
        return response()->json($all_brands,200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandRequest $request)
    {
        $validated_data=$request->validated();
        $brand=Brand::create($validated_data);
        return response()->json($brand,201);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $brand=Brand::find($id);
            return response()->json($brand, 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Brand Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandRequest $request, int $id)
    {
        try{
            $brand=Brand::find($id);
            $brand->update($request->validated());
            return response()->json($brand, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Brand Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        try{
            $brand=Brand::find($id);
            $brand->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Brand Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
