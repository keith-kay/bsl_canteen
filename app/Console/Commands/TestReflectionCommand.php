<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use ReflectionClass;

class TestReflectionCommand extends Command
{
    protected $signature = 'test:reflection';

    protected $description = 'Test reflection on CustomUser model';

    public function handle()
    {
        $userReflection = new ReflectionClass('App\Models\CustomUser');
        $methods = $userReflection->getMethods();

        foreach ($methods as $method) {
            $this->info($method->name);
        }
    }
}