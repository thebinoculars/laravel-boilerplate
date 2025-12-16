<?php

namespace App\Modules\User\Repositories;

use App\Modules\User\Models\User;
use App\Repositories\BaseRepository;

class UserRepository extends BaseRepository
{
    protected function getModelClass(): string
    {
        return User::class;
    }
}
