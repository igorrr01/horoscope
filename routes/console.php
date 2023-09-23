<?php

use DefStudio\Telegraph\Models\TelegraphBot;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


// php artisan registerCommand 
Artisan::command('registerCommand', function () {
    $bot = TelegraphBot::find(1);
    $bot->registerCommands([
        'command1' => 'command 1 description',
        'command2' => 'command 2 description'
    ])->send();
});

// php artisan unregisterCommand
Artisan::command('unregisterCommand', function () {
    $bot = TelegraphBot::find(1);
    $bot->unregisterCommands()->send();
});

