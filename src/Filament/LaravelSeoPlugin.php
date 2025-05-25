<?php

namespace KiranoDev\LaravelSeo\Filament;

use Closure;
use Filament\Contracts\Plugin;
use Filament\Panel;
use KiranoDev\LaravelSeo\Filament\Resources\SeoResource;

class LaravelSeoPlugin implements Plugin
{
    protected ?Closure $canViewAnyCallback = null;

    public function withAccessCheck(Closure $callback): static
    {
        $this->canViewAnyCallback = $callback;
        return $this;
    }

    public function getId(): string
    {
        return 'seo';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->resources([
                SeoResource::class,
            ]);
    }

    public static function make(): static
    {
        return app(static::class);
    }

    public function boot(Panel $panel): void
    {
        //
    }
}