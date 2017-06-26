<?php

namespace App\Http\Composers;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SidebarComposer
{
	public function compose(View $view){
		$user = Auth::user();

		$view->with('user', $user);
	}
}