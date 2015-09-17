<?php namespace Unnutz\LaravelEnvironmentConfig\Listeners;

use InvalidArgumentException;
use Symfony\Component\Finder\Finder;

class LoadConfigurationEventListener
{
    /**
     * Handle the event.
     *
     * @return void
     */
    public function onConfigurationLoaded()
    {
        if (file_exists(app()->getCachedConfigPath()))
            return;

        $environment = app()->environment();

        $environmentConfigPath = sprintf('%s/%s', app()->configPath(), $environment);

        try {

            foreach (Finder::create()->files()->name('*.php')->in($environmentConfigPath) as $file) {

                $key = basename($file, '.php');

                $config = app('config')->get($key, []);

                app('config')->set($key, array_merge_recursive(require $file, $config));
            }

        } catch (InvalidArgumentException $exception) {

        }
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        $events->listen(
            'bootstrapped: Illuminate\Foundation\Bootstrap\LoadConfiguration',
            'Unnutz\LaravelEnvironmentConfig\Listeners\LoadConfigurationEventListener@onConfigurationLoaded'
        );
    }
}