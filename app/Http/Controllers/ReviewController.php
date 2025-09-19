<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function index()
    {
        $all_reviews=Review::all();
        return response()->json($all_reviews, 200);
    }

    public function userReviews(int $id)
    {
        $user=User::where('id',$id);
        if(!$user){
            return response()->json(__('Sorry, User Not Found'));
        }
        $user_reviews=$user->reviews();
        if(!$user_reviews){
            return response()->json(__('Sorry, No Reviews Found'));
        }
        return response()->json($user_reviews, 200);
    }

    public function productReviews($id)
    {
        $product=Product::where('id',$id);
        if(!$product){
            return response()->json(__('Sorry, Product Not Found'));
        }
        $product_reviews=$product->reviews();
        if(!$product_reviews){
            return response()->json(__('Sorry, No Reviews Found'));
        }
        return response()->json($product_reviews, 200);
    }

    public function store(ReviewRequest $request)
    {
        $validated_data=$request->validated();
        $user_id=Auth::user()->id;
        $exists=Review::where('product_id',$request->product_id)
                ->where('user_id',$user_id)
                ->exists();
        if($exists){
            return response()->json(__('You Already Reviewed This Product'),400);
        }
        $validated_data['user_id']=$user_id;
        $review=Review::create($request->validated());
        $review->load('product');
        return response()->json($review, 201);
    }

    // public function show(int $id)
    // {
    //     try{
    //         $review=Review::find($id);
    //         return response()->json($review, 200);
    //     }
    //     catch(ModelNotFoundException $e){
    //         return response()->json([
    //             'message'=>__('Review Not Found'),
    //             'details'=>$e->getMessage()]
    //             ,404);
    //     }catch(Exception $e){
    //         return response()->json($e->getMessage());
    //     }
    // }

    // public function update(ReviewRequest $request, int $id)
    // {
    //     try{
    //         $review=Review::find($id);
    //         $review->update($request->validated());
    //         return response()->json($review, 201);
    //     }
    //     catch(ModelNotFoundException $e){
    //         return response()->json([
    //             'message'=>__('Review Not Found'),
    //             'details'=>$e->getMessage()]
    //             ,404);
    //     }catch(Exception $e){
    //         return response()->json($e->getMessage());
    //     }
    // }

    public function destroy(int $id)
    {
            $user_id=Auth::user()->id;
            $review=Review::where('product_id',$id)
                    ->where('user_id',$user_id)
                    ->first();
                    if(!$review){
                        return response()->json(__('Review Not Found'),404);
                    }
            $review->delete();
            return response()->json(null, 204);
    }
}
