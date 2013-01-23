<?php namespace Duellsy\Getpocket;

use Illuminate\Support\ServiceProvider;

class GetpocketServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('duellsy/getpocket');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['getpocket'] = $this->app->share(function($app)
        {
            return new Getpocket;
        });

        include __DIR__.'/routes.php';

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
