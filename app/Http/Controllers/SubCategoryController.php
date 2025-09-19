<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubCategoryRequest;
use App\Models\SubCategory;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_subCategories=SubCategory::all();
        return response()->json($all_subCategories, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SubCategoryRequest $request)
    {
        $validated_data=$request->validated();
        $subCategory=SubCategory::create($validated_data);
        return response()->json($subCategory, 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try{
            $subCategory=SubCategory::find($id);
            return response()->json($subCategory, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('SubCategory Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SubCategoryRequest $request, int $id)
    {
        try{
            $subCategory=SubCategory::find($id);
            $subCategory->update($request->validated());
            return response()->json($subCategory, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('SubCategory Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try{
            $subCategory=SubCategory::find($id);
            $subCategory->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('SubCategory Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
