<?php

namespace App\Http\Controllers;

use App\Http\Requests\PanerRequest;
use App\Models\Paner;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PanerController extends Controller
{
    public function index()
    {
        $all_paners=Paner::where('is_activ',true)->orderBy('order')->get();
        return response()->json($all_paners , 200);
    }

    public function store(PanerRequest $request)
    {
        $validated_data=$request->validated();
        if($request->hasFile('image')){
            $path=$request->file('image')->store('panners','public');
            $validated_data['image']=$path;
            $validated_data['order']=Paner::max('order') + 1;
        }
        $paner=Paner::create($validated_data);
        return response()->json($paner, 201);
    }

    public function show(int $id)
    {
        try{
            $paner=Paner::find($id);
            return response()->json($paner, 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Paner Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    // public function update(PanerRequest $request, int $id)
    // {
    //     try{
    //         $paner=Paner::find($id);
    //         $paner->update($request->validated());
    //         return response()->json($paner, 201);
    //     }
    //     catch(ModelNotFoundException $e){
    //         return response()->json([
    //             'message'=>__('Paner Not Found'),
    //             'details'=>$e->getMessage()]
    //             ,404);
    //     }catch(Exception $e){
    //         return response()->json($e->getMessage());
    //     }
    // }

    public function destroy(int $id)
    {
        try{
            $paner=Paner::find($id);
            Storage::disk('public')->delete($paner->image);
            $paner->delete();
            return response()->json(null , 204);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Paner Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
