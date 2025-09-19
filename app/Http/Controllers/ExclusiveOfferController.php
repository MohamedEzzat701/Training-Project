<?php

namespace App\Http\Controllers;

use App\Http\Requests\ExclusiveOfferRequest;
use App\Models\ExclusiveOffer;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class ExclusiveOfferController extends Controller
{
    
    public function index()
    {
        $all_offers=ExclusiveOffer::with('products')->paginate(3);
        return response()->json($all_offers, 200);
    }

    public function store(ExclusiveOfferRequest $request)
    {
        $new_offer=ExclusiveOffer::create($request->validated());
        return response()->json($new_offer, 201);
    }

    public function show(int $id)
    {
        try{
            $offer=ExclusiveOffer::with('products')->find($id);
            return response()->json($offer, 200);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Offer Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function update(ExclusiveOfferRequest $request, int $id)
    {
        try{
            $offer=ExclusiveOffer::find($id);
            $offer->update($request->validated());
            return response()->json($offer, 201);
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Offer Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try{
            $offer=ExclusiveOffer::find($id);
            $offer->delete();
        }
        catch(ModelNotFoundException $e){
            return response()->json([
                'message'=>__('Offer Not Found'),
                'details'=>$e->getMessage()]
                ,404);
        }catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }
}
