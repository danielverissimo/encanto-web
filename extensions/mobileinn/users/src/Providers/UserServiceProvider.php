<?php namespace Mobileinn\Users\Providers;

use Cartalyst\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider {
	public function register()
	{
		$this->app->bind('Platform\Users\Models\User', function ($app){
			return $app['Mobileinn\Users\Models\User'];
		});

		$this->app['Illuminate\Contracts\Http\Kernel']->pushMiddleware('Mobileinn\Users\Middleware\VerifyToken');
	}
}