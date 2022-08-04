<?php

declare(strict_types=1);

namespace JamesMills\Uuid;

use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\Builder;

trait HasUuidTrait
{
    protected static function bootHasUuidTrait(): void
    {
        static::creating(function ($model) {
            if (!$model->uuid) {
                $model->uuid = (string)Uuid::uuid4();
            }
        });
    }

    public static function findByUuidOrFail(string $uuid): Builder
    {
        return self::whereUuid($uuid)->firstOrFail();
    }

    public function scopeWithUuid(Builder $query, string $uuid): Builder
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeWithUuids(Builder $query, array $uuids): Builder
    {
        return $query->whereIn('uuid', $uuids);
    }

    public function getRouteKeyName(): string
    {
        return 'uuid';
    }
}
