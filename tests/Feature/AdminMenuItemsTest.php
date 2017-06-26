<?php

namespace Tests\Feature;

use App\MenuItem;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminMenuItemsTest extends TestCase
{
    use DatabaseMigrations;

    private $menuItem;
    private $user;
    private $data;

    public function setUp()
    {
        parent::setUp();

        $this->menuItem = factory(MenuItem::class)->create();
        $this->user = factory(User::class)->make();
        $this->data = [
            'text' => 'Dashboard',
            'link' => '/dashboard'
        ];
    }

    /**
     * @test
     */
    public function can_create_menu_item()
    {
        $response = $this->actingAs($this->user)->post('/menu-items', $this->data);

        $response->assertRedirect('/menu-items');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('menu_items', [
            'text' => $this->data['text'],
            'link' => $this->data['link']
        ]);
    }

    /**
     * @test
     */
    public function text_is_required_for_store()
    {
        // Missing text
        $this->data['text'] = null;

        $response = $this->actingAs($this->user)->post('/menu-items', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('text', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function link_is_required_for_store()
    {
        // Missing link
        $this->data['link'] = null;

        $response = $this->actingAs($this->user)->post('/menu-items', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('link', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function can_update_menu_item()
    {
        $response = $this->actingAs($this->user)->put("/menu-items/{$this->menuItem->id}", $this->data);

        $response->assertRedirect('/menu-items');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('menu_items', [
            'text' => $this->data['text'],
            'link' => $this->data['link']
        ]);
    }

    /**
     * @test
     */
    public function text_is_required_for_update()
    {
        // Missing text
        $this->data['text'] = null;

        $response = $this->actingAs($this->user)->put("/menu-items/{$this->menuItem->id}", $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('text', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function link_is_required_for_update()
    {

        // Missing link
        $this->data['link'] = null;

        $response = $this->actingAs($this->user)->put("/menu-items/{$this->menuItem->id}", $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('link', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function can_delete_menu_item()
    {
        $response = $this->actingAs($this->user)->delete("/menu-items/{$this->menuItem->id}");

        $response->assertRedirect('/menu-items');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('menu_items', [
            'text' => $this->menuItem['text'],
            'link' => $this->menuItem['link']
        ]);
    }

    /**
     * @test
     */
    public function menu_items_list()
    {
        $response = $this->actingAs($this->user)->get('/menu-items');

        $response->assertSee(htmlentities($this->menuItem->text), ENT_QUOTES);
        $response->assertSee(htmlentities($this->menuItem->link), ENT_QUOTES);
        $response->assertViewHas('menuItems');
    }

    /**
     * @test
     */
    public function menu_item_create()
    {
        $response = $this->actingAs($this->user)->get('/menu-items/create');

        $response->assertSee('Create Menu Item');
    }

    /**
     * @test
     */
    public function menu_item_edit()
    {
        $response = $this->actingAs($this->user)->get("/menu-items/{$this->menuItem->id}/edit");

        $response->assertViewHas('menuItem');
        $response->assertSee('Update Menu Item');

        $response->assertSee(htmlentities($this->menuItem->text, ENT_QUOTES));
        $response->assertSee(htmlentities($this->menuItem->link, ENT_QUOTES));
    }
}
