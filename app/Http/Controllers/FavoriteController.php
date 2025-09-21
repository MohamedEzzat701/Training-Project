<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{

    public function index()
    {
        $all_favorites=Favorite::with('product')->paginate(10);
        return response()->json($all_favorites, 200);
    }

    public function userFavorites(int $id)
    {
        $user=User::where('id',$id);
        if(!$user){
            return response()->json(__('Sorry, User Not Found'));
        }
        $user_favorites=$user->favorites();
        if(!$user_favorites){
            return response()->json(__('Sorry, No Favorites Found'));
        }
        return response()->json($user_favorites, 200);
    }

    public function store(FavoriteRequest $request)
    {
        $validated_data=$request->validated();
        $user_id=Auth::user()->id;
        $exists=Favorite::where('product_id',$request->product_id)
                ->where('user_id',$user_id)
                ->exists();
        if($exists){
            return response()->json(__('Product Already in Favorites'),400);
        }
        $validated_data['user_id']=$user_id;
        $favorite=Favorite::create($request->validated());
        return response()->json($favorite, 201);
    }

    public function destroy(int $id)
    {
        $user_id=Auth::user()->id;
        $favorite=Favorite::where('product_id',$id)
                ->where('user_id',$user_id)
                ->first();
                if(!$favorite){
                    return response()->json(__('Not Found In Favorites'),404);
                }
        $favorite->delete();
        return response()->json(null, 204);
    }
}
