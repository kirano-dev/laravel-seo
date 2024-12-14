<?php

namespace KiranoDev\LaravelSeo\Filament\Resources\SeoResource\Pages;

use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use KiranoDev\LaravelSeo\Filament\Resources\SeoResource;

class EditSeo extends EditRecord
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
