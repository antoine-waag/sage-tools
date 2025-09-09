<?php

declare (strict_types = 1);

namespace AntoineWaag\SageTools\Console\Commands;

use AntoineWaag\SageTools\Services\ClassService;
use Illuminate\Console\Command;

class ListBlocks extends Command
{
    protected $signature   = 'list:blocks';
    protected $description = 'List all custom blocks';

    public function handle()
    {
        $header = ['Name', 'Slug', 'Class'];

        $data = [];

        foreach (ClassService::getAllCustomBlockClasses() as $blockClass) {
            $slug  = $blockClass::$slug;
            $title = $blockClass::$title;

            $data[] = [$title, $slug, $blockClass];
        }

        $this->table($header, $data);
    }
}
