<?php

namespace KiranoDev\LaravelSeo\Filament\Resources\SeoResource\Pages;

use Filament\Actions;
use KiranoDev\LaravelSeo\Filament\Resources\SeoResource;
use Filament\Resources\Pages\ListRecords;

class ListSeos extends ListRecords
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
