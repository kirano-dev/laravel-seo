<?php

namespace KiranoDev\LaravelSeo\Filament\Resources;

use Filament\Forms\Components\Textarea;
use KiranoDev\LaravelSeo\Filament\Resources\SeoResource\Pages;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use KiranoDev\LaravelSeo\Models\Seo;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    protected static ?string $navigationIcon = 'heroicon-s-globe-alt';

    protected static ?string $label = 'SEO';
    protected static ?string $pluralLabel = 'SEO';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('url')
                    ->label('URL')
                    ->url()
                    ->required(),
                TextInput::make('title')
                    ->label('Title'),
                Textarea::make('description')
                    ->label('Description'),
                Textarea::make('keywords')
                    ->label('Keywords'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('url'),
                TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSeos::route('/'),
            'create' => Pages\CreateSeo::route('/create'),
            'edit' => Pages\EditSeo::route('/{record}/edit'),
        ];
    }
}
