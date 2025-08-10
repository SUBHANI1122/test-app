<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Transalation;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use PDO;

class EloquentTranslationRepository implements TranslationRepositoryInterface
{
     public function find(int $id)
    {
        return Transalation::with('tags')->find($id);
    }

    public function create(array $data)
    {
        return DB::transaction(function () use ($data) {
            $tags = $data['tags'] ?? [];
            unset($data['tags']);

            $translation = Transalation::create($data);

            if (!empty($tags)) {
                $tagIds = $this->getOrCreateTagIds($tags);
                $translation->tags()->sync($tagIds);
            }

            return $translation->load('tags');
        });
    }

    public function update(int $id, array $data): bool
    {
        return DB::transaction(function () use ($id, $data) {
            $translation = Transalation::findOrFail($id);
            $tags = $data['tags'] ?? null;
            unset($data['tags']);

            $updated = $translation->update($data);

            if (is_array($tags)) {
                $tagIds = $this->getOrCreateTagIds($tags);
                $translation->tags()->sync($tagIds);
            }

            return $updated;
        });
    }

    public function search(array $filters, int $perPage = 50): LengthAwarePaginator
    {
        $query = Transalation::query();

        if (!empty($filters['locale'])) {
            $query->where('locale', $filters['locale']);
        }

        if (!empty($filters['key'])) {
            $query->where('key', 'like', $filters['key'] . '%');
        }

        if (!empty($filters['content'])) {
            if (DB::getPdo()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'mysql') {
                $query->whereRaw('MATCH(content) AGAINST(? IN BOOLEAN MODE)', [$filters['content'] . '*']);
            } else {
                $query->where('content', 'like', '%' . $filters['content'] . '%');
            }
        }

        if (!empty($filters['tags'])) {
            $tags = is_array($filters['tags']) ? $filters['tags'] : explode(',', $filters['tags']);
            $query->whereHas('tags', function ($q) use ($tags) {
                $q->whereIn('name', $tags);
            });
        }

        if (!empty($filters['context'])) {
            $query->where('context', $filters['context']);
        }

        return $query->with('tags')->paginate($perPage);
    }

    public function exportByLocale(string $locale): \Generator
    {
        $query = Transalation::where('locale', $locale)->orderBy('key');

        foreach ($query->cursor() as $translation) {
            yield [$translation->key => $translation->content];
        }
    }

    private function getOrCreateTagIds(array $tags): array
    {
        $existing = Tag::whereIn('name', $tags)->get()->keyBy('name');
        $ids = [];

        foreach ($tags as $tagName) {
            if (isset($existing[$tagName])) {
                $ids[] = $existing[$tagName]->id;
                continue;
            }

            $tag = Tag::create(['name' => $tagName]);
            $ids[] = $tag->id;
        }

        return $ids;
    }
}