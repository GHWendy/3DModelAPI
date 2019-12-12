<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Figure;
use App\Comment;
use App\Policies\FigurePolicy;
use App\Policies\CommentPolicy;
use App\Policies\GroupPolicy;
use App\Policies\UserPolicy;
use App\User;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Figure::class => FigurePolicy::class,
        Comment::class => CommentPolicy::class,
        Group::class => GroupPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
