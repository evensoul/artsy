<?php

namespace App\Providers;

use App\Models\Admin;
use Fereron\CategoryTree\MenuBuilder;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Gate;
use Laravel\Nova\Nova;
use Laravel\Nova\NovaApplicationServiceProvider;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Nova::footer(function ($request) {
            return Blade::render('
            <p class="text-center">&copy; {!! $year !!} Artsy</p>
        ', ['year' => date('Y')]);
        });
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            return Admin::query()->where('email', $user->email)->exists();
        });
    }

    /**
     * Get the dashboards that should be listed in the Nova sidebar.
     *
     * @return array
     */
    protected function dashboards()
    {
        return [
            new \App\Nova\Dashboards\Main,
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [
//            new TreeView([
//                // ['NAME_IN_SIDEBAR', 'TABLE_NAME']
//                ['Categories', 'categories']
//            ]),
//            new Tree(),
//            new PriceTracker(),
            // todo change to new MenuBuilder()
            MenuBuilder::make(),
            (new \vmitchell85\NovaLinks\Links())
                ->addLink('Categories', '/resources/nova-menus/1'),
        ];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
