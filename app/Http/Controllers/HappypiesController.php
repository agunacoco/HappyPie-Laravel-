<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class HappypiesController extends Controller
{
    public function index(){

        $menus = Menu::all();

        return view("happypies.menu", ["menus"=>$menus]);
    }
}
