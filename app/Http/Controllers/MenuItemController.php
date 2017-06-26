<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMenuItem;
use App\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $menuItems = MenuItem::get();
        return view('menu-items.index', compact('menuItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('menu-items.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreMenuItem|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMenuItem $request)
    {
        MenuItem::create($request->only(['text', 'link']));
        return redirect('/menu-items')->with('success', 'Menu item created');
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
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(MenuItem $menuItem)
    {
        return view('menu-items.edit', compact('menuItem'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreMenuItem|Request $request
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(StoreMenuItem $request, MenuItem $menuItem)
    {
        $menuItem->update($request->only(['text', 'link']));
        return redirect('/menu-items')->with('success', 'Menu item updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param MenuItem $menuItem
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();
        return redirect('/menu-items')->with('success', 'Menu item deleted');
    }
}
