<?php

namespace App\Services;

use App\Repositories\BaseRepository;

abstract class BaseService
{
    protected BaseRepository $repository;

    public function __construct()
    {
        $this->repository = $this->resolveRepository();
    }

    abstract protected function getRepositoryClass(): string;

    protected function resolveRepository(): BaseRepository
    {
        $class = $this->getRepositoryClass();

        return app($class);
    }
}
