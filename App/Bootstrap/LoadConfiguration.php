<?php


namespace App\Bootstrap;


use Illuminate\Config\Repository;
use Laravel\Lumen\Application;
use Symfony\Component\Finder\Finder;

class LoadConfiguration
{
    public function bootstrap(Application $app): void
    {
        $repository = new Repository();
        foreach (Finder::create()->in($app->getConfigurationPath())->name('*.php') as $file){
            $repository->set($file->getFilenameWithoutExtension(), require $file->getPathname());
        }
        $app->instance('config', $repository);
    }
}