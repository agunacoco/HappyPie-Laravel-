<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function index(){

        if(auth()->user()){
            $userid = auth()->user()->id;
            $menus = User::find($userid)->menus()->get();
            return $menus;
        }

        
    }

    public function store($menu_id){
        
        $menu = Menu::find($menu_id);
        
        return $menu->users()->save(auth()->user());
    }

    public function update(Request $request, $menu_id){
        $count = $request->count;
        if($count){   
            if ($count == "plus") {
                $userid = auth()->user()->id;
                $originalCount=User::find($userid)->menus()->where('menu_id',$menu_id)->value('count');
                $value=$originalCount+1;
                $cart = User::find($userid)->menus()->updateExistingPivot($menu_id, ['count' => $value]);
                return $value;
            } else if($count == "minus"){
                $userid = auth()->user()->id;
                $originalCount=User::find($userid)->menus()->where('menu_id',$menu_id)->value('count');
                $value=$originalCount-1;
                $cart = User::find($userid)->menus()->updateExistingPivot($menu_id, ['count' => $value]);
                return $value;
            }
        }
    }

    public function destroy($menu_id){

        $user = User::find(auth()->user()->id);
        $user->menus()->detach($menu_id);

        return $user;
    }
}
