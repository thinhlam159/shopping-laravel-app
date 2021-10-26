<?php

namespace App\Http\Controllers;

use App\Components\Recusive;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function getMenu($menuParentId = '')
    {
        $menuList = Menu::all();
        $recusive = new Recusive($menuList);
        $menuHtmlSelect = $recusive->menuRecusive($menuParentId, 0, '');
        return $menuHtmlSelect;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menu = Menu::paginate(5);
        return view('admin.menu.index')->with(compact('menu'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('add_menu');
        $menuSelectHtml = $this->getMenu();
        return view('admin.menu.create')->with(compact('menuSelectHtml'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('add_menu');
        $data = $request->validate(
            [
                'name' => 'required|unique:menus|max:255',
                'parent_id' => 'required|int',
            ], [
                'name.require' => 'Ten menu la bat buoc!',
                'parent_id.require' => 'Parent menu la bat buoc!',
            ]
        );
        $menu = new Menu();
        $menu->name = $data['name'];
        $menu->parent_id = $data['parent_id'];
        $menu->slug = Str::slug($data['name']);
        $menu->save();
        return redirect()->route('menu.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('edit_menu');
        $menu = Menu::find($id);
        $menuSelectHtml = $this->getMenu($menu->perant_id);
        return view('admin.menu.edit')->with(compact('menu', 'menuSelectHtml'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authorize('edit_menu');
        $data = $request->validate(
            [
                'name' => 'required|max:255',
                'parent_id' => 'required|int',
            ], [
                'name.require' => 'Ten menu la bat buoc!',
                'parent_id.require' => 'Parent menu la bat buoc!',
            ]
        );
        $menu = Menu::find($id);
        $menu->name = $data['name'];
        $menu->parent_id = $data['parent_id'];
        $menu->slug = Str::slug($data['name']);
        $menu->save();
        return redirect()->route('menu.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('delete_menu');
        $menu = Menu::find($id);
        $menu->delete();
        return redirect()->back()->with('status', 'Xoa menu thanh cong');
    }
}
