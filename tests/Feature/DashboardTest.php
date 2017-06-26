<?php

namespace Tests\Feature;

use App\MenuItem;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DashboardTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * @test
     */
    public function can_view_items_assigned_to_user()
    {
        // Arrange
        $user = factory(User::class)->create();
        $menuItem = factory(MenuItem::class)->create();
        $user->menuItems()->attach($menuItem->id);

        // Action
        $response = $this->actingAs($user)->get("/dashboard");

        // Assertion
        $response->assertStatus(200);
        $response->assertSee(htmlentities($user->name, ENT_QUOTES));
        $response->assertSee($menuItem->text);
    }
}
