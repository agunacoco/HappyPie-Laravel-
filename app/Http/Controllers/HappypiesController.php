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

    public function mypage(){
        return view("happypies.mypage");
    }

    public function ordersheet(){
        if(auth()->user()->id == 1){
            return view("happypies.ordersheet");
        }
    }
    public function payhistory(){
        return view("happypies.payhistory");
    }

    public function orderlist(){
        if(auth()->user()->id !== 1){
            return view("happypies.orderList");
        }
        
        
    }



    
}
