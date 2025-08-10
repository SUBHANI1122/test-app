<?php
namespace App\Repositories;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

interface TranslationRepositoryInterface
{
    public function find(int $id);

    public function create(array $data);

    public function update(int $id, array $data): bool;

    public function search(array $filters, int $perPage = 50): LengthAwarePaginator;

    public function exportByLocale(string $locale): \Generator; // generator for streaming
}