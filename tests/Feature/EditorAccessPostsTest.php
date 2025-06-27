<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\House;
use Illuminate\Foundation\Testing\Concerns\WithoutExceptionHandlingHandler;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Component\CssSelector\Parser\Handler\WhitespaceHandler;
use Tests\TestCase;

class EditorAccessPostsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Create panel_user permission (required by Shield to access panel)
        Permission::create(['name' => 'panel_user', 'guard_name' => 'web']);

        // Create permissions for posts
        $permissions = [
            'view_post',
            'view_any_post',
            'create_post',
            'update_post',
            'delete_post',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Editor role
        $this->editorRole = Role::create(['name' => 'Editor', 'guard_name' => 'web']);

        // Assign panel_user and post permissions to Editor role
        $this->editorRole->givePermissionTo(['panel_user', ...$permissions]);
    }

    public function test_editor_can_see_posts_menu_in_navigation()
    {
        // $this->withoutExceptionHandling();
        // Create a house
        $house = House::create(['name' => 'Test House']);

        // Create user with Editor role
        $editor = User::factory()->create([
            'house_id' => $house->id,
        ]);
        $editor->assignRole('Editor');

        // Act as the editor
        $this->actingAs($editor);

        // Visit the admin panel
        $response = $this->get('/app');

        // Assert user is authenticated and can access admin
        $response->assertStatus(200);

        // Assert Posts menu is visible in navigation
        $response->assertSee('Posts');
        $response->assertSee('Content Management');
    }

    public function test_editor_can_access_posts_index_page()
    {
        // Create user with Editor role
        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        // Act as the editor
        $this->actingAs($editor);

        // Visit posts index
        $response = $this->get('/app/posts');

        // Assert can access posts page
        $response->assertStatus(200);
        $response->assertSee('Posts');
    }

    public function test_editor_can_create_new_post()
    {
        // Create user with Editor role
        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        // Act as the editor
        $this->actingAs($editor);

        // Visit create post page
        $response = $this->get('/app/posts/create');

        // Assert can access create page
        $response->assertStatus(200);
        $response->assertSee('Create Post');
    }

    public function test_editor_cannot_see_user_management_menu()
    {
        // Create user with Editor role
        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        // Act as the editor
        $this->actingAs($editor);

        // Visit the admin panel
        $response = $this->get('/app');

        // Assert user management is not visible
        $response->assertDontSee('User Management');
        $response->assertDontSee('Users', false);
        $response->assertDontSee('Roles', false);
    }

    public function test_user_without_editor_role_cannot_see_posts_menu()
    {
        // Create regular user without any role but with panel access
        $user = User::factory()->create();
        $regularRole = Role::create(['name' => 'Regular User', 'guard_name' => 'web']);
        $regularRole->givePermissionTo('panel_user');
        $user->assignRole('Regular User');

        // Act as regular user
        $this->actingAs($user);

        // Visit the admin panel
        $response = $this->get('/app');

        // Assert can access panel but Posts menu is not visible
        $response->assertStatus(200);
        $response->assertDontSee('Posts');
        $response->assertDontSee('Content Management');
    }

    public function test_navigation_menu_items_based_on_permissions()
    {
        // Create user with Editor role
        $editor = User::factory()->create();
        $editor->assignRole('Editor');

        $this->actingAs($editor);

        // Get the navigation items that should be visible
        $visibleItems = [
            'Dashboard' => true,
            'Posts' => true,
            'Houses' => false, // Editor shouldn't see Houses
            'Users' => false,  // Editor shouldn't see Users
            'Roles' => false,  // Editor shouldn't see Roles
        ];

        $response = $this->get('/app');

        foreach ($visibleItems as $item => $shouldSee) {
            if ($shouldSee) {
                $response->assertSee($item);
            } else {
                $response->assertDontSee($item, false);
            }
        }
    }
}