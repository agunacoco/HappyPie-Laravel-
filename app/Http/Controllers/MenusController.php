<?php

namespace App\Http\Controllers;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenusController extends Controller
{
    public function index(Request $request){
        
        if($request->category){
            $category = $request->category;
            if ($category == 'all') {
                $menus = Menu::latest('created_at')->get();
                return $menus;
    
            }else if($category == 'cookiepie'){
                $categories = Category::where('category','=', 'desserts')->pluck('menu_id');
                $menus = Menu::latest('created_at')->find($categories);
                return $menus;
    
            }else if($category == 'cake'){
                $categories = Category::where('category','=', 'cake')->pluck('menu_id');
                $menus = Menu::latest('created_at')->find($categories);
                return $menus;
    
            }else if($category == 'drink'){
                $categories = Category::where('category','=', 'drink')->pluck('menu_id');
                $menus = Menu::latest('created_at')->find($categories);
                return $menus;
            }
        }
        if($request->search){
            $search = $request->search;
            $menus = Menu::where('menuK', 'like', '%'.$search.'%')->latest('created_at')->get();

            return $menus;
        }    
    }

    public function store(Request $request){

        $this->validate($request, [
            'content' => 'required|min:3',
            'menuK' => 'required',
            'menuE' => 'required',
            'price' => 'required', 
            'image' => 'required', 
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
        
        $menu_id = Menu::where('image', '=', $filename)->first();
        $name = $request->categories;
        
        if($name){
            $array_category = Str::of($name)->explode(',');
            for($i = 0; $i<count($array_category); $i++){
                $category = new Category;
                $category->category = $array_category[$i];
                $category->menu_id = $menu_id->id;
                $category->save();
            }
        }

        return $filename;
    }
    public function show($menu_id){

        $menu = Menu::find($menu_id);

        return view('happypies.show', ["menu"=>$menu]);
    }

    public function destroy(Request $request, $menu_id){

        $menu = Menu::find($menu_id);
        if($request->user()->can('delete', $menu)){
            $menu->delete();
            return $menu;
        } else{
            abort(403);
        }
    }

    public function update(Request $request, $menu_id){

        $this->validate($request, [
            'content' => 'required|min:3',
            'menuK' => 'required',
            'menuE' => 'required',
            'price' => 'required', 
        ]);

        $menu = Menu::find($menu_id);
        $this->authorize('update', $menu);

        if($request->hasFile('image')){
            Storage::delete('public/images/'.$menu->image);
            $filename = time().'_'.$request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('public/images', $filename);
            $menu->image = $filename;
            $menu->save();
        }

        $menu->update([
            'menuK' => $request->input('menuK'),
            'menuE' => $request->input('menuE'),
            'price' => $request->input('price'),
            'content' => $request->input('content'),
        ]);

        return $menu;

    }

}
