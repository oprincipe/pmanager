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
			$event->menu->add('MAIN NAVIGATION');

			if(Auth::user()->role_id == Role::SUPER_ADMIN) {
				$event->menu->add(['icon' => 'users', 'text' => 'Users', 'url' => route('users.index'),]);
			}

            $assigned_tasks = Auth::user()->assigned_tasks(TaskStatus::getActiveIds(), true);
			$assigned_tasks_totals = 0;
			if($assigned_tasks) {
			    foreach($assigned_tasks as $assigned_task)
                {
                    $assigned_tasks_totals += $assigned_task->totals;
                }
            }

			$event->menu->add(
				[
					'icon'  => 'building-o',
					'text'  => 'My companies',
					'url'   => route('companies.index'),
				],
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

			if(Auth::user()->role_id != Role::CUSTOMER) {
				$event->menu->add(['icon' => 'users', 'text' => 'My customers', 'url' => route('customers.index'),]);
			}


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
