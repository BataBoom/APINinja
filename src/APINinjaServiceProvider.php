<?php

namespace BataBoom\APINinja;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use BataBoom\APINinja\Commands\APINinjaCommand;
use Spatie\LaravelPackageTools\Commands\Concerns;

class APINinjaServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('api-ninja')
            ->hasConfigFile()
            ->hasCommand(APINinjaCommand::class)
            ->hasInstallCommand(function(InstallCommand $command) {
                $command
                    ->publishConfigFile()
                    ->copyAndRegisterServiceProviderInApp()
                    ->askToStarRepoOnGitHub('bataboom/APINinja');
            });
    }
}
