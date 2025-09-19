<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_categories=Category::all();
        return response()->json($all_categories, 200);

    }

    public function store(StoreCategoryRequest $request)
    {
        $validated_data=$request->validated();
        $category=Category::create($validated_data);
        return response()->json($category, 201);
    }

    public function show(int $id)
    {
        try{
            $category=Category::find($id);
            return response()->json($category, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Category Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, string $id)
    {
        try{
            $category=Category::find($id);
            $category->update($request->validated());
            return response()->json($category, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Category Not Found'),
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
            $category=Category::find($id);
            $category->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Category Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
