<?php

declare (strict_types = 1);

namespace AntoineWaag\SageTools\Providers;

use AntoineWaag\SageTools\Hooks\AbstractHook;
use AntoineWaag\SageTools\Hooks\DefaultGutenbergHooks;
use AntoineWaag\SageTools\Hooks\DefaultWordPressHooks;
use AntoineWaag\SageTools\Hooks\PostHooks;
use AntoineWaag\SageTools\Hooks\RankMathHooks;
use AntoineWaag\SageTools\Services\ClassService;
use AntoineWaag\SageTools\Services\FileService;
use Roots\Acorn\Exceptions\SkipProviderException;
use Roots\Acorn\Sage\SageServiceProvider;

class HooksServiceProvider extends SageServiceProvider
{
    public function boot(): void
    {
        $this->initHooks();
    }

    private function initHooks(): void
    {
        try {
            foreach (FileService::getClassesPathsFromPath(get_template_directory() . '/app/Hooks') as $classPath) {
                require_once $classPath;
            }

            $defaultClasses = [
                PostHooks::class,
                RankMathHooks::class,
                DefaultGutenbergHooks::class,
                DefaultWordPressHooks::class,
            ];

            $hookClasses = array_filter(get_declared_classes(), function ($class) {
                return is_subclass_of($class, AbstractHook::class);
            });

            foreach (array_merge($hookClasses, $defaultClasses) as $hookClass) {
                if ($className = ClassService::getClassNameFromFullName($hookClass)) {
                    if (! str_starts_with($className, 'Abstract')) {
                        $class = new $hookClass();

                        if (method_exists($class, 'init')) {
                            $class->init();
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            throw new SkipProviderException($e->getMessage());
        }
    }
}
