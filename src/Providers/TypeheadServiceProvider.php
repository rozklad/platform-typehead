<?php namespace Sanatorium\Typehead\Providers;

use Cartalyst\Support\ServiceProvider;
use Product;

class TypeheadServiceProvider extends ServiceProvider {

	/**
	 * {@inheritDoc}
	 */
	public function boot()
	{
		// Register all the default hooks
        $this->registerHooks();
	}

	/**
	 * {@inheritDoc}
	 */
	public function register()
	{

	}

	/**
     * Register all hooks.
     *
     * @return void
     */
    protected function registerHooks()
    {
        $hooks = [
            'shop.head' => 'sanatorium/typehead::hooks.typehead',
        ];

        $manager = $this->app['sanatorium.hooks.manager'];

        foreach ($hooks as $position => $hook) {
            $manager->registerHook($position, $hook);
        }
    }


}
