<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Category;
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

        $array_category = Str::of($request->categories)->explode(',');
        dd($array_category);

        $menu = Menu::create([
            'menuK' => $request->input('menuK'),
            'menuE' => $request->input('menuE'),
            'price' => $request->input('price'),
            'content' => $request->input('content'),
            'image' => $filename,
            'user_id' => auth()->user()->id,
        ]);

        

        $category = new Category;

        return $filename;
    }
    public function show($menu_id){

        $menu = Menu::find($menu_id);

        return view('happypies.show', ["menu"=>$menu]);
    }
}
