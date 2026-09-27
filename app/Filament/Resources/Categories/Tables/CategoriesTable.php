<?php

namespace App\Filament\Resources\Categories\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->contentGrid([
                'default' => 1,
                'sm' => 2,
                'md' => 2,
                'lg' => 3,
                'xl' => 3,
            ])
            ->columns([
                Stack::make([
                    ImageColumn::make('image')
                        ->label('')
                        ->size(100)
                        ->extraImgAttributes([
                            'class' => 'object-contain mx-auto',
                        ]),

                    TextColumn::make('name')
                        ->weight('bold')
                        ->searchable(),

                    TextColumn::make('is_active')
                        ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                        ->badge()
                        ->color(fn ($state) => $state ? 'success' : 'danger'),

                    TextColumn::make('created_at')
                        ->dateTime()
                        ->sortable(),
                ])
                ->space(2)
                ->alignment(\Filament\Support\Enums\Alignment::Center), // Bikin semua konten rata tengah
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}