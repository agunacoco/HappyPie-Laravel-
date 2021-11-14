<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class HappypiesController extends Controller
{
    public function index(){

        return view("happypies.menu");
    }

    public function shoppingcart(){
        return view("happypies.shoppingcart");
    }
}
