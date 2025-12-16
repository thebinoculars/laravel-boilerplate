<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('user:report')->everyMinute();
