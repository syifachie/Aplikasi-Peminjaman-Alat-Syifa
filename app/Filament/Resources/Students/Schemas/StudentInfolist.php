<?php

namespace App\Filament\Resources\Students\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StudentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Personal Information')
                    ->schema([
                        ImageEntry::make('profile_picture')
                            ->disk('public')
                            ->height(100)
                            ->hiddenLabel()
                            ->alignCenter(),
                    ])
                    ->columnSpan(1),

                Section::make('Student Information')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('Student Name')
                            ->icon('heroicon-o-user-circle'),
                        TextEntry::make('nisn')
                            ->label('NISN')
                            ->icon('heroicon-o-identification'),
                        TextEntry::make('classroom.name')
                            ->label('Class')
                            ->icon('heroicon-o-building-office'),
                        TextEntry::make('gender')
                            ->label('Gender')
                            ->badge(),
                            TextEntry::make('phone_number')
                            ->label('Phone Number')
                            ->icon('heroicon-o-phone'),
                        TextEntry::make('address')
                            ->label('Address')
                            ->icon('heroicon-o-map-pin'),
                        
                    ])
                    ->columnSpan(2)
                    ->columns(3 ),
            ])
            ->columns(3);
    }
}