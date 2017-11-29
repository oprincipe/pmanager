<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use function route;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
	public function boot(Dispatcher $events)
	{
		$events->listen(BuildingMenu::class, function (BuildingMenu $event) {
			$event->menu->add('MAIN NAVIGATION');
			$event->menu->add(
				[
					'icon'  => 'building-o',
 					'text'  => 'Companies',
					'url'   => route('companies.index'),
                ],
				[
					'icon'  => 'briefcase',
					'text'  => 'All projects',
					'url'   => route('projects.index')
				]
			);
/*
			                            <li><a href="{{ route('tasks.index') }}"><i class="fa fa-tasks"></i> All tasks</a></li>
                                        <li><a href="{{ route('users.index') }}"><i class="fa fa-user-o"></i> All users</a></li>
                                        <li><a href="{{ route('roles.index') }}"><i class="fa fa-key"></i> All roles</a></li>
*/
		});
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
