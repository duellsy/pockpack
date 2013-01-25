<?php namespace Duellsy\Pockpack;

use Illuminate\Support\ServiceProvider;

/**
 * The Pockpack package is a quick wrap to make connecting and
 * consuming the pocket API much simpler and quicker to get up and running.
 * For information / documentation on using this package, please refer to:
 * https://github.com/duellsy/pockpack
 *
 * @package    Pockpack
 * @version    1.1
 * @author     Chris Duell
 * @license    MIT
 * @copyright  (c) 2013 Chris Duell
 * @link       https://github.com/duellsy/pockpack
 */

class PockpackServiceProvider extends ServiceProvider {

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
		$this->package('duellsy/pockpack');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['pockpack'] = $this->app->share(function($app)
        {
            return new Pockpack;
        });

		$this->app['pockpack.auth'] = $this->app->share(function($app)
        {
            return new PockpackAuth;
        });

		$this->app['pockpack.queue'] = $this->app->share(function($app)
        {
            return new PockpackQueue;
        });

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
