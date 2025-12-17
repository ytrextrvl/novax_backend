<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('novax:ping', fn() => $this->info('pong'));
