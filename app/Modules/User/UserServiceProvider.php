<?php

namespace App\Modules\User;

use App\Providers\ModuleServiceProvider;

class UserServiceProvider extends ModuleServiceProvider
{
    protected function modulePath(): string
    {
        return __DIR__;
    }

    protected function moduleName(): string
    {
        return 'user';
    }
}
