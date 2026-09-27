<?php

namespace App\Filament\Resources\Assets\Schemas;

use App\Models\Asset;   
use App\Models\Category;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Fieldset;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AssetForm
{
    protected static function recalculateStock(Get $get, Set $set):void
    {
        $good = (int)$get('good_quantity');
        $damaged = (int)$get('damaged_quantity');
        $borrowed = (int)$get('borrowed_quantity');
        $lost = (int)$get('lost_quantity');

        $set('available_quantity', $good - $borrowed);
        $set ('total_quantity', $good + $damaged + $borrowed + $lost);

    }

    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make()
                ->schema([
                    Fieldset::make('Asset Detail')
                        ->schema([
                            Select::make('category_id')
                                ->required()
                                ->relationship('category', 'name')
                                ->label('Category')
                                ->reactive()
                                ->afterStateUpdated(function (Get $get, Set $set)
                                {
                                    $category = Category::find($get('category_id'));

                                    if (!$category){
                                        return;   
                                    }

                                    $prefix = strtoupper(Str::substr($category->name,0,3));

                                    $lastCode = Asset::where('code', 'like', $prefix. '%')
                                    ->orderBy('code', 'desc')
                                    ->value('code');

                                    if ($lastCode){
                                        $number = (int) substr($lastCode, 3);
                                        $nextnumber = $number + 1;
                                    }

                                    else{
                                        $nextnumber = 1;
                                    }

                                    $code = $prefix .str_pad($nextnumber, 3, '0', STR_PAD_LEFT);
                                    $set('code', $code);
                                }),
                            TextInput::make('code')
                                ->readOnly()
                                ->reactive()
                                ->required(),
                            
                            TextInput::make('name')
                                ->required()
                                ->columnSpanFull(),
                            RichEditor::make('description')
                                ->label('description')
                                ->columnSpanFull()
                                ->extraAttributes([
                                    'style' => 'min-height: 250px'
                                ]),
                            FileUpload::make('image')
                                ->label('Asset Picture')
                                ->disk('public')
                                ->directory('Asset Picture')
                                ->default(null)
                                ->columnSpanFull()

                       
                    ]),
                    Toggle::make('is_available')
                    ->label('Status ')
                    ->required(),
                       
                    ])->columnSpan(2),
                
                    Fieldset::make('Asset Condition / Stock')
                    ->schema([
                        TextInput::make('good_quantity')
                            ->required()
                            ->label('Good')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set)=>self::recalculateStock($get, $set)),

                        TextInput::make('damaged_quantity')
                            ->required()
                            ->label('Damaged')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set)=>self::recalculateStock($get, $set)),

                        TextInput::make('borrowed_quantity')
                            ->required()
                            ->label('Borrowed')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set)=>self::recalculateStock($get, $set)),

                        TextInput::make('lost_quantity')
                            ->required()
                            ->label('Lost')
                            ->default(0)
                            ->reactive()
                            ->afterStateUpdated(fn(Get $get, Set $set)=>self::recalculateStock($get, $set)),

                        TextInput::make('available_quantity')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            ->label('Available')
                            ->belowContent('Available Asset for borrowing')
                            ->default(0),
                        TextInput::make('total_quantity')
                            ->numeric()
                            ->required()
                            ->readOnly()
                            ->label('Total')
                            ->default(0),
                    ])->columnSpan(1),
                
                
            ])->columns(3);
    }
}
