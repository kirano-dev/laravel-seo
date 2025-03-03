<?php

namespace KiranoDev\LaravelSeo\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    const CACHE_KEY = 'seo';

    protected $table = 'seo';

    protected $fillable = [
        'url',
        'title',
        'keywords',
        'description',
    ];

    public static function findByUrl(?string $url): ?Seo {
        return self::where('url', $url)->first();
    }

    public static function getDefault(): array
    {
        return config('seo.default');
    }

    public function getCacheKey(): string
    {
        return "seo.$this->url";
    }

    public function saveCache(): void {
        cache()->forever($this->getCacheKey(), $this);
    }

    public function clearCache(): void {
        cache()->forget($this->getCacheKey());
    }

    protected static function boot(): void
    {
        parent::boot();

        self::created(static fn (Seo $seo) => $seo->saveCache());
        self::updated(static fn (Seo $seo) => $seo->saveCache());
        self::deleted(static fn (Seo $seo) => $seo->clearCache());
    }
}