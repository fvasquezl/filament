<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Post;
use App\Models\House;
use App\Models\User;
use App\Policies\PostPolicy;
use App\Policies\HousePolicy;
use App\Policies\UserPolicy;

class PolicyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Register policies
        Gate::policy(Post::class, PostPolicy::class);
        Gate::policy(House::class, HousePolicy::class);
        Gate::policy(User::class, UserPolicy::class);
    }
}