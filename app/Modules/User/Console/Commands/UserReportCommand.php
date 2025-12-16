<?php

namespace App\Modules\User\Console\Commands;

use App\Modules\User\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class UserReportCommand extends Command
{
    protected $signature = 'user:report';

    protected $description = 'User report (scheduler test)';

    public function handle(): int
    {
        Log::info('User report executed', ['user_count' => User::count()]);

        $this->info('Report executed');

        return self::SUCCESS;
    }
}
