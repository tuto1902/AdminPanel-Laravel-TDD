<?php

namespace Tests\Unit;

use App\Providers\ComposerServiceProvider;
use Illuminate\Support\Facades\View;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ComposerServiceProviderTest extends TestCase
{
    /**
     * @test
     */
    public function can_boot_sidebar_view_composer()
    {
        View::shouldReceive('composer')->once()->withArgs(['section.sidebar', 'App\Http\Composers\SidebarComposer']);

        $composerServiceProvider = new ComposerServiceProvider($this->app);

        $composerServiceProvider->boot();
    }
}
