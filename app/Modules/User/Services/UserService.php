<?php

namespace App\Modules\User\Services;

use App\Modules\User\Models\User;
use App\Modules\User\Repositories\UserRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;

class UserService extends BaseService
{
    protected function getRepositoryClass(): string
    {
        return UserRepository::class;
    }

    public function getAllUsers(): Collection
    {
        return $this->resolveRepository()->all();
    }

    public function createUser(array $data): User
    {
        return $this->resolveRepository()->create($data);
    }
}
