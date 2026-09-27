<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class AssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('name'),
                TextEntry::make('code'),
                TextEntry::make('total_quantity')
                    ->numeric(),
                TextEntry::make('good_quantity')
                    ->numeric(),
                TextEntry::make('damaged_quantity')
                    ->numeric(),
                TextEntry::make('borrowed_quantity')
                    ->numeric(),
                TextEntry::make('lost_quantity')
                    ->numeric(),
                IconEntry::make('is_available')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime(),
                TextEntry::make('updated_at')
                    ->dateTime(),
            ]);
    }
}
