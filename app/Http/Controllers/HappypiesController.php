<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Http\Request;

class HappypiesController extends Controller
{
    public function index(){

        return view("happypies.menu");
    }

    public function cartindex(){
        if(auth()->user()){
            $userid = auth()->user()->id;
            $menus = User::find($userid)->menus()->get();
            return view("happypies.shoppingcart", ['menus'=>$menus]);
        }else{
            return view("happypies.shoppingcart");
        }
    }

    
}
