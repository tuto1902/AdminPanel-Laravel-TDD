<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUser;
use App\Http\Requests\UpdateUser;
use App\MenuItem;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menuItems = MenuItem::get();
        return view('users.create', compact('menuItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUser|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUser $request)
    {
        $userData = $request->only(['name', 'email', 'password']);
        $userData['password'] = bcrypt($userData['password']);
        $user = User::create($userData);
        $user->menuItems()->attach($request->get('menu-items'));
        return redirect('/users')->with('success', 'User created');
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
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function edit(User $user)
    {
        $menuItems = MenuItem::get();
        $userMenuItems = $user->menuItems()->pluck('menu_items.id')->toArray();
        return view('users.edit', compact('user', 'menuItems', 'userMenuItems'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUser|Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function update(UpdateUser $request, User $user)
    {
        $data = [
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ];

        if($request->has('password')){
            $data['password'] = bcrypt($request->get('password'));
        }

        $user->update($data);
        $user->menuItems()->sync($request->get('menu-items'));
        return redirect('/users')->with('success', 'User updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     * @throws \Exception
     * @internal param int $id
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect('/users')->with('success', 'User deleted');
    }
}
