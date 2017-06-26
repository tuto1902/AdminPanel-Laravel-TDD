<?php


namespace App\Providers;


use App\Http\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
	public function boot()
	{
		View::composer('section.sidebar', SidebarComposer::class);
	}
}