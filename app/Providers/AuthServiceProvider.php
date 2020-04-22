<?php

namespace App\Providers;

//use App\Article;
//use App\Policies\ArticlePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        //Article::class => ArticlePolicy::class,//이거 추가 안해도 네이밍 규칙만 맞으면 된대
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        Gate::define('Admin_ability', function ($user) {
            return $user->isAdmin;
        });
        //
    }
}
