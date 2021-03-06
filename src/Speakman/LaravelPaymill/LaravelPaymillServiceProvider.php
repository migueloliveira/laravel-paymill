<?php namespace Speakman\LaravelPaymill;

use Illuminate\Support\ServiceProvider;

class LaravelPaymillServiceProvider extends ServiceProvider {

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
		$this->publishes([
            __DIR__.'/../../config/config.php' => config_path('paymill.php'),
        ]);

        $public_key = config('paymill.public_key');

        $this->app['view']->share('paymill_public_key', $public_key);
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$this->app['paymill'] = $this->app->share(function ($app) {

            $private_key = config('paymill.private_key');

            return new Paymill($private_key);
            
        });

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('paymill');
	}

}
