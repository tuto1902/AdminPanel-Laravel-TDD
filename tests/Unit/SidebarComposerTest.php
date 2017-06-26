<?php

namespace Tests\Unit;

use App\Http\Composers\SidebarComposer;
use App\User;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;

class SidebarComposerTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function can_compose_sidebar_view()
    {
        $user = factory(User::class)->create();
        Auth::shouldReceive('user')->once()->andReturn($user);

        $view = m::mock('Illuminate\View\View');
        $view->shouldReceive('with')->withArgs(['user', $user]);

        $composer = new SidebarComposer();
        $composer->compose($view);
    }
}
