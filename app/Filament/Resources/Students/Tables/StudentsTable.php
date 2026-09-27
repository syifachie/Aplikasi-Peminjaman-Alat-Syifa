<?php

namespace App\Filament\Resources\Students\Tables;

use Filament\Actions\ActionGroup; 
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Columns\Layout\Grid; 
use Filament\Support\Enums\FontWeight;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
        ->contentGrid([
            'xl' => 4,
            'lg' => 3,
            'md' => 2,  
        ])
            ->columns([
                Grid::make([
                    'default' => 1
                ])->schema([
                ImageColumn::make('profile_picture')
                    ->disk('public')
                    ->imageSize(100),

                    Stack::make([
                        TextColumn::make('user.name')
                    ->label('Student Name')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold),
                TextColumn::make('nisn')
                    ->label('NISN') 
                    ->searchable()
                    ->icon('heroicon-o-identification'),
                TextColumn::make('classroom.name')
                    ->label('Class')
                    ->searchable()
                    ->sortable()
                    ->icon('heroicon-o-building-office'),
                TextColumn::make('phone_number')
                    ->label('Phone Number')
                    ->searchable()
                    ->icon('heroicon-o-phone'),
                TextColumn::make('gender')
                    ->label('Gender')
                    ->badge(),
                    ])
                
                ]),

               

            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(), 
                    DeleteAction::make(),
                ])
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
