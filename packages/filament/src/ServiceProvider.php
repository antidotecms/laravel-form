<?php

namespace Antidote\LaravelFormFilament;

use Antidote\LaravelForm\Domain\Fields\Field;
use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\PluginServiceProvider;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Symfony\Component\Finder\SplFileInfo;

class ServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        //@todo do we need to publiush transactions in order to use those already written for Filament?
        $package->name('laravel-form-filament');

        $register = [];

        $this->registerComponentsFromDirectory(
            Field::class,
            $register,
            __DIR__.'/../../form/src/Domain/Fields',
            'Antidote/LaravelForm/Domain/Fields'
        );

        //@todo add in registration for common location (prob set via config) for fields in an app - also factor in other packages

        //dump($register);

        $this->app->bind('fieldRegistry', function($app) use ($register) {
            return $register;
        });
    }

    //modified from FilamentServiceProvider
    protected function registerComponentsFromDirectory(string $baseClass, array &$register, ?string $directory, ?string $namespace)
    {
        if (blank($directory) || blank($namespace)) {
            return;
        }

//        if (Str::of($directory)->startsWith(config('filament.livewire.path'))) {
//            return;
//        }

        $filesystem = app(Filesystem::class);

        if ((! $filesystem->exists($directory)) && (! Str::of($directory)->contains('*'))) {
            return;
        }

        $namespace = Str::of($namespace);

        $register = array_merge(
            $register,
            collect($filesystem->allFiles($directory))
                ->map(function (SplFileInfo $file) use ($namespace): string {
                    $variableNamespace = $namespace->contains('*') ? str_ireplace(
                        ['\\' . $namespace->before('*'), $namespace->after('*')],
                        ['', ''],
                        Str::of($file->getPath())
                            ->after(base_path())
                            ->replace(['/'], ['\\']),
                    ) : null;

                    if (is_string($variableNamespace)) {
                        $variableNamespace = (string) Str::of($variableNamespace)->before('\\');
                    }

                    return (string) $namespace
                        ->append('\\', $file->getRelativePathname())
                        ->replace('*', $variableNamespace)
                        ->replace(['/', '.php'], ['\\', '']);
                })
                ->filter(fn (string $class): bool => is_subclass_of($class, $baseClass) && (! (new \ReflectionClass($class))->isAbstract()))
                ->mapWithKeys(function($value) {
                    return [$value => $value];
                })
                ->all(),
        );
    }
}