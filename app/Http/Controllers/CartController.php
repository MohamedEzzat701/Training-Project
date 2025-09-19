<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request)
    {
        $cartItems=$request->user()->cartItems()->with('product')->get();
        if(!$cartItems){
            return response()->json(__('Sorry No CartItems Found'));
        }
        return response()->json($cartItems, 200);
    }

    public function store(CartRequest $request)
    {
        $validated_data=$request->validated();
        $existing=Cart::where('user_id',$request->user()->id)
                        ->where('product_id',$request->product_id)
                        ->first();
        if($existing){
            $existing->quantity+=$request->quantity;
            $existing->save();
            return response()->json(__('The Quantity Updated In Cart'),200);
        }
        $validated_data['user_id']=$request->user()->id;
        $cart=Cart::create($validated_data);
        return response()->json([
            'message'=>__('The Product Added To Cart'),
            'cart'=>$cart
        ], 201);
    }

    public function update(CartRequest $request, int $cart_id)
    {
        $cart=Cart::where('id',$cart_id)
                    ->where('user_id',$request->user()->id)
                    ->first();
        if(!$cart){
            return response()->json(__('Sorry Cart Not Found'));
        }
        $validated_data=$request->validated();
        $validated_data['user_id']=$request->user()->id;
        $cart->update($validated_data);
        return response()->json(__('The Cart Updated'), 200);
    }

    public function destroy(Request $request , int $cart_id)
    {
        $cart=Cart::where('id',$cart_id)
                    ->where('user_id',$request->user()->id)
                    ->first();
        if(!$cart){
            return response()->json(__('Sorry Cart Not Found'));
        }
        $cart->delete();
        return response()->json(null, 204);
    }
}
