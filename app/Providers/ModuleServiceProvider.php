<?php

namespace App\Providers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

abstract class ModuleServiceProvider extends ServiceProvider
{
    abstract protected function modulePath(): string;

    abstract protected function moduleName(): string;

    public function boot(): void
    {
        $this->registerConfigs();
        $this->registerRoutes();
        $this->registerMigrations();
        $this->registerViews();
        $this->registerTranslations();
        $this->registerViewComponents();
        $this->registerCommands();
    }

    protected function registerConfigs(): void
    {
        $configPath = $this->modulePath() . '/Config';

        if (File::isDirectory($configPath)) {
            foreach (File::files($configPath) as $file) {
                $this->mergeConfigFrom(
                    $file->getPathname(),
                    "{$this->moduleName()}." . pathinfo($file, PATHINFO_FILENAME)
                );
            }
        }
    }

    protected function registerRoutes(): void
    {
        $routeFiles = ['web.php', 'api.php', 'console.php'];

        foreach ($routeFiles as $fileName) {
            $file = $this->modulePath() . "/Routes/{$fileName}";

            if (File::exists($file)) {
                $this->loadRoutesFrom($file);
            }
        }
    }

    protected function registerMigrations(): void
    {
        $migrationsPath = $this->modulePath() . '/Database/migrations';

        if (File::isDirectory($migrationsPath)) {
            $this->loadMigrationsFrom($migrationsPath);
        }
    }

    protected function registerViews(): void
    {
        $viewsPath = $this->modulePath() . '/Resources/views';

        if (File::isDirectory($viewsPath)) {
            $this->loadViewsFrom($viewsPath, $this->moduleName());
        }
    }

    protected function registerTranslations(): void
    {
        $langPath = $this->modulePath() . '/Resources/lang';

        if (File::isDirectory($langPath)) {
            $this->loadTranslationsFrom($langPath, $this->moduleName());
            $this->loadJsonTranslationsFrom($langPath);
        }
    }

    protected function registerViewComponents(): void
    {
        $componentsPath = $this->modulePath() . '/View/Components';

        if (File::isDirectory($componentsPath)) {
            Blade::componentNamespace(
                "{$this->moduleNamespace()}\\View\\Components",
                $this->moduleName()
            );
        }
    }

    protected function registerCommands(): void
    {
        $commandsPath = $this->modulePath() . '/Console/Commands';

        if (File::isDirectory($commandsPath)) {
            $classes = [];

            foreach (File::files($commandsPath) as $file) {
                $class = $this->resolveClassFromFile($file->getPathname());
                if ($class) {
                    $classes[] = $class;
                }
            }

            if (!empty($classes)) {
                $this->commands($classes);
            }
        }
    }

    protected function resolveClassFromFile(string $file): ?string
    {
        $content = file_get_contents($file);

        if (preg_match('/namespace\s+([^;]+);/', $content, $m1)
            && preg_match('/class\s+([^\s]+)/', $content, $m2)) {
            return "{$m1[1]}\\{$m2[1]}";
        }

        return null;
    }
}
