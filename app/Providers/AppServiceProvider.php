<?php

namespace App\Providers;

use App\Role;
use App\TaskStatus;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
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
			$event->menu->menu = array();
			$event->menu->add('MAIN MENU');

			$assigned_tasks = Auth::user()->assigned_tasks(TaskStatus::getActiveIds(), true);
			$assigned_tasks_totals = 0;
			if($assigned_tasks) {
			    foreach($assigned_tasks as $assigned_task)
                {
                    $assigned_tasks_totals += $assigned_task->totals;
                }
            }

            //Profile menu
            $event->menu->add(['avatar' => Auth::user()->avatar() , 'text' => Auth::user()->fullName(), 'url' => route('profile.show'),]);

            if(Auth::user()->role_id == Role::SUPER_ADMIN) {
                $event->menu->add(['icon' => 'users', 'text' => 'Users', 'url' => route('users.index'),]);
            }

            $event->menu->add(['icon' => 'users', 'text' => 'My customers', 'url' => route('customers.index'),]);

            $event->menu->add(
				/*[
					'icon'  => 'building-o',
					'text'  => 'My companies',
					'url'   => route('companies.index'),
				],*/
                [
                    'icon'  => 'briefcase',
                    'text'  => 'My projects',
                    'badge' => Auth::user()->assigned_projects()->count(),
                    'url'   => route('projects.index')
                ],
                [
                    'icon'  => 'tasks',
                    'text'  => 'Active tasks',
                    'badge' => $assigned_tasks_totals,
                    'url'   => URL::to('/tasks/?search_task_status_id=actives')
                ]
			);


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
