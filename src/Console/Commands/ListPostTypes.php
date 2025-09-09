<?php

declare (strict_types = 1);

namespace AntoineWaag\SageTools\Console\Commands;

use AntoineWaag\SageTools\Services\ClassService;
use Illuminate\Console\Command;

class ListPostTypes extends Command
{
    protected $signature   = 'list:posttypes';
    protected $description = 'List all custom blocks';

    public function handle()
    {
        $header = ['Name', 'Slug', 'Class'];

        $data = [];

        foreach (ClassService::getAllCustomPostTypeClasses() as $postTypeClass) {
            $slug = $postTypeClass::$slug;
            $name = (new $postTypeClass())->getConfig()['args']['label'];

            $data[] = [$name, $slug, $postTypeClass];
        }

        $this->table($header, $data);

        return;
    }
}
