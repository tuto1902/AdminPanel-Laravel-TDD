<?php

namespace Tests\Feature;

use App\MenuItem;
use App\User;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class AdminUsersTest extends TestCase
{
    use DatabaseMigrations;
    
    private $user;
    private $data;
    private $newData;
    private $menuItems;
    
    public function setUp()
    {
        parent::setUp();
        
        $this->user = factory(User::class)->make();
        $this->actingAs($this->user);
        $this->menuItems = factory(MenuItem::class, 3)->create();
        $this->data = [
            'name' => 'Test User',
            'email' => 'test@test.com',
            'password' => 'secret',
            'password_confirmation' => 'secret',
            'menu-items' => $this->menuItems->pluck('id')->toArray()
        ];

        $menuItems = $this->menuItems->pluck('id');
        $menuItems->pop();

        $this->newData = [
            'name' => 'Update User',
            'email' => 'update@test.com',
            'password' => 'new_password',
            'password_confirmation' => 'new_password',
            'menu-items' => $menuItems->toArray()
        ];
    }

    /**
     * @test
     */
    public function it_can_create_user()
    {
        $response = $this->post('/users', $this->data);

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'name' => $this->data['name'],
            'email' => $this->data['email']
        ]);
        $this->assertEquals(3, User::find(1)->menuItems()->count());
    }

    /**
     * @test
     */
    public function user_name_is_required_for_store()
    {
        // Missing user name
        $this->data['name'] = null;

        $response = $this->post('/users', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('name', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function email_is_required_for_store()
    {
        // Missing email
        $this->data['email'] = null;

        $response = $this->post('/users', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('email', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function email_is_unique_for_store()
    {
        $user = create('App\User');
        // Dupe email
        $this->data['email'] = $user->email;

        $response = $this->actingAs($user)->post('/users', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('email', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function password_is_required_for_store()
    {
        // Missing password
        $this->data['password'] = null;

        $response = $this->post('/users', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('password', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function password_is_confirmed_for_store()
    {
        // Mismatch password
        $this->data['password_confirmation'] = 'foo';

        $response = $this->post('/users', $this->data);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('password', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function can_update_user()
    {
        $user = create('App\User');
        $user->menuItems()->attach($this->menuItems->pluck('id')->toArray());

        $response = $this->actingAs($user)->put("/users/{$user->id}", $this->newData);

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('users', [
            'name' => $this->newData['name'],
            'email' => $this->newData['email']
        ]);
        $this->assertEquals(2, User::find(1)->menuItems()->count());
    }

    /**
     * @test
     */
    public function user_name_is_required_for_update()
    {
        $user = create('App\User');
        $user->menuItems()->attach($this->data['menu-items']);
        // Missing user name
        $this->newData['name'] = null;

        $response = $this->actingAs($user)->put("/users/{$user->id}", $this->newData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('name', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function password_is_confirmed_for_update()
    {
        $user = create('App\User');
        $user->menuItems()->attach($this->data['menu-items']);
        // Missing user name
        $this->newData['password_confirmation'] = 'foo';

        $response = $this->actingAs($user)->put("/users/{$user->id}", $this->newData);

        $response->assertStatus(302);
        $response->assertSessionHas('errors');
        $this->assertArrayHasKey('password', Session::get('errors')->toArray());
    }

    /**
     * @test
     */
    public function can_delete_user()
    {
        $user = create('App\User');
        $user->menuItems()->attach($this->data['menu-items']);

        $response = $this->actingAs($user)->delete("/users/{$user->id}");

        $response->assertRedirect('/users');
        $response->assertSessionHas('success');
        $this->assertDatabaseMissing('users', [
            'name' => $user['name'],
            'email' => $user['email']
        ]);
    }

    /**
     * @test
     */
    public function it_can_display_all_users ()
    {
        $user = create('App\User');

        $response = $this->actingAs($user)->get('/users');

        $response->assertSee($user->email);
    }

    /**
     * @test
     */
    public function it_can_create_users ()
    {
        $response = $this->get('/users/create');

        $response->assertViewHas('menuItems');
        $response->assertSee('Create User');
    }

    /**
     * @test
     */
    public function it_can_update_users ()
    {
        $user = create('App\User');
        $user->menuItems()->attach($this->newData['menu-items']);

        $response = $this->actingAs($user)->get("/users/{$user->id}/edit");

        $response->assertViewHas('user');
        $response->assertViewHas('menuItems');
        $response->assertViewHas('userMenuItems');
        $response->assertSee('Update User');

        $response->assertSee($user->email);
        $response->assertSee("<option value=\"{$this->newData['menu-items'][0]}\" selected>");
        $response->assertSee("<option value=\"{$this->newData['menu-items'][1]}\" selected>");
    }
}
