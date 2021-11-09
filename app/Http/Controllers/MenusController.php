<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use Illuminate\Http\Request;

class MenusController extends Controller
{
    public function index(){
        $menus = Menu::all();
        
        return $menus;
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
            'menuK' => $request->input('menuK'),
            'menuE' => $request->input('menuE'),
            'price' => $request->input('price'),
            'content' => $request->input('content'),
            'image' => $filename,
            'user_id' => auth()->user()->id,
        ]);

        dd($menu);

        return $filename;
    }
}
