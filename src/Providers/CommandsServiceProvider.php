<?php

declare (strict_types = 1);

namespace AntoineWaag\SageTools\Providers;

use AntoineWaag\SageTools\Console\Commands\ListBlocks;
use AntoineWaag\SageTools\Console\Commands\ListPostTypes;
use AntoineWaag\SageTools\Console\Commands\ListTaxonomies;
use AntoineWaag\SageTools\Console\Commands\MakeAdmin;
use AntoineWaag\SageTools\Console\Commands\MakeBlock;
use AntoineWaag\SageTools\Console\Commands\MakeHook;
use AntoineWaag\SageTools\Console\Commands\MakePostType;
use AntoineWaag\SageTools\Console\Commands\MakeRepository;
use AntoineWaag\SageTools\Console\Commands\MakeTaxonomy;
use AntoineWaag\SageTools\Console\Commands\MakeTemplate;
use Roots\Acorn\Exceptions\SkipProviderException;
use Roots\Acorn\Sage\SageServiceProvider;

class CommandsServiceProvider extends SageServiceProvider
{
    public function boot()
    {
        try {
            $this->commands([
                MakeBlock::class,
                MakePostType::class,
                MakeTaxonomy::class,
                MakeTemplate::class,
                MakeAdmin::class,
                MakeRepository::class,
                MakeHook::class,
                ListBlocks::class,
                ListPostTypes::class,
                ListTaxonomies::class,
            ]);
        } catch (\Exception $e) {
            throw new SkipProviderException($e->getMessage());
        }
    }
}
