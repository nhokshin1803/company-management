<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            \App\Repositories\Board\BoardRepositoryInterface::class,
            \App\Repositories\Board\BoardRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Card\CardRepositoryInterface::class,
            \App\Repositories\Card\CardRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\List\ListRepositoryInterface::class,
            \App\Repositories\List\ListRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\Comment\CommentRepositoryInterface::class,
            \App\Repositories\Comment\CommentRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\User\UserRepositoryInterface::class,
            \App\Repositories\User\UserRepository::class,
        );
        $this->app->singleton(
            \App\Repositories\UserBoard\UserBoardRepositoryInterface::class,
            \App\Repositories\UserBoard\UserBoardRepository::class,
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
