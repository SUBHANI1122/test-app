<?php

namespace App\Services;

use App\Repositories\TranslationRepositoryInterface;

class TranslationService
{
    private TranslationRepositoryInterface $repository;

    public function __construct(TranslationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function createTranslation(array $data)
    {
        return $this->repository->create($data);
    }

    public function updateTranslation(int $id, array $data): bool
    {
        return $this->repository->update($id, $data);
    }

    public function getTranslation(int $id)
    {
        return $this->repository->find($id);
    }

    public function search(array $filters, int $perPage = 50)
    {
        return $this->repository->search($filters, $perPage);
    }

    public function exportLocale(string $locale): \Generator
    {
        return $this->repository->exportByLocale($locale);
    }
}