<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index(){
        return view('happypies.menu');
    }

    public function store(Request $request){


        $this->validate($request, [
            'content' => 'required|min:3',
            'menuK' => 'required',
            'menuE' => 'required',
            'price' => 'required', 
        ]);

        $filename=null;

        if($request->hasFile('image')){
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images', $filename);
        }

        $menu = Menu::create([
            'menu(k)' => $request->input('menuK'),
            'menu(e)' => $request->input('menuE'),
            '가격' => $request->input('price'),
            'content' => $request->input('content'),
            'image' => $filename,
            'user_id' => auth()->user()->id,
        ]);

        return $menu;
    }
}
