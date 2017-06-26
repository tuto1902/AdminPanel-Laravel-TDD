<?php

namespace Tests\Unit;

use App\MenuItem;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class UserTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function can_attach_menu_items()
    {
        // Arrange
        $menuItem = factory(MenuItem::class)->create();
        $user = factory(User::class)->create();

        // Action
        $user->menuItems()->attach($menuItem->id);

        // Assert
        $this->assertEquals(1, $user->menuItems->count());
    }
}
