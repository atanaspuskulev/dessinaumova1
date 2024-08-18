<?php

declare(strict_types=1);

namespace App\Http\Services;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class TagService
{
    public function exists(string $name): bool
    {
        return (bool) Tag::where('name', $name)->first();
    }

    public function getBy(array $filters): Collection
    {
        $query = Tag::query();

        foreach($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->get();
    }

    public function getOneBy(array $filters): object
    {
        $query = Tag::query();

        foreach($filters as $key => $value) {
            $query->where($key, $value);
        }

        return $query->first();
    }

    public function create(array $data): Tag
    {
        if(empty($data['name'])) {
            throw new InvalidArgumentException('Tag name is required');
        }

        return Tag::create($data);
    }

    public function update(Tag $tag, array $data): bool
    {
        return $tag->update($data);
    }

    public function delete(Tag $tag): void
    {
        $tag->delete();
    }
}
