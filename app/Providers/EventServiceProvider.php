<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->autoRegisterServiceProviders();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

    }

    protected function autoRegisterServiceProviders(): void
    {
        $dir=new \RecursiveDirectoryIterator(app_path('/Services'));
        $files = new \RecursiveIteratorIterator($dir);
        foreach($files as $file){
            $phpFile = $file->getFileName();
            $isProvider = preg_match('/Provider.php$/', $phpFile);
            if($isProvider)
            {
                $class = str_replace(['.php',], [''], $phpFile);
                $path = $file->getPath();
                $relativePath = str_replace(app_path() . '/', '', $path);
                $namespace = 'App\\' . str_replace('/', '\\', $relativePath);
                $regProvider = $namespace."\\".$class;
                if (class_exists($regProvider)) {
                    $this->app->register($regProvider);
                }
            }
        }
    }
}
