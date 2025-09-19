<?php

namespace App\Http\Controllers;

use App\Http\Requests\BestSellingRequest;
use App\Models\BestSelling;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class BestSellingController extends Controller
{
    public function index()
    {
        $best_selling=BestSelling::with('products')->paginate(3);;
        return response()->json($best_selling, 200);
    }

    public function store(BestSellingRequest $request)
    {
        $new_item=BestSelling::create($request->validated());
        return response()->json($new_item, 201);
    }

    public function show(int $id)
    {
        try{
            $item=BestSelling::with('products')->find($id);
            return response()->json($item, 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Item Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(BestSellingRequest $request, int $id)
    {
        try{
            $item=BestSelling::find($id);
            $item->update($request->validated());
            return response()->json($item, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Item Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try{
            $item=BestSelling::find($id);
            $item->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Item Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
