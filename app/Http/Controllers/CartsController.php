<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class CartsController extends Controller
{
    public function index(){

        $userid = auth()->user()->id;
        $menus = User::find($userid)->menus()->get();

        return view("happypies.shoppingcart", ['menus'=>$menus]);
    }

    public function store($menu_id){
        
        $menu = Menu::find($menu_id);
        
        return $menu->users()->save(auth()->user());
    }
}
