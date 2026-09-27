<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn; 
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;   
use Filament\Tables\Filters\TernaryFilter;  
use Filament\Tables\Columns\ColumnGroup;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ColumnGroup::make('Asset Details',[
                    ImageColumn::make('image')
                    ->disk('public')
                    ->imageSize(50),
                
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable(),
                TextColumn::make('code')
                    ->label('Code')
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                ]),
                ColumnGroup::make('Asset Condition / Stok', [
                    TextColumn::make('good_quantity')
                    ->label('Good')
                    ->numeric(),
                TextColumn::make('damaged_quantity')
                    ->label('Damaged')
                    ->numeric(),
                TextColumn::make('borrowed_quantity')
                    ->label('Borrowed')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('lost_quantity')
                    ->label('Lost')
                    ->numeric(),
                TextColumn::make('total_quantity')
                    ->numeric()
                    ->label('Total'),
                TextColumn::make('available_quantity')
                    ->label('Available')
                    ->numeric()
                    ->getStateUsing(fn($record)=>$record->good_quantity - $record->borrowed_quantity)
                    ->badge(),
                ]),
                
                
                
                IconColumn::make('is_available')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label('Category')
                    ->relationship('category', 'name'),
                TernaryFilter::make('is_available')
                    ->label('Availability'),
            ])
            ->recordActions([
                ActionGroup::make([
                    ViewAction::make(),
                    EditAction::make(),
                    DeleteAction::make(),
                ]),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}