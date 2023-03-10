<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers;

use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;

class EnquiriesRelationManager extends \Filament\Resources\RelationManagers\RelationManager
{
    protected static string $relationship = 'enquiries';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id'),
                TextColumn::make('from_name')
                    //->visible(fn($record) => isset($record->data->name))
                    ->getStateUsing(fn($record) => $record->data->name ?? ''),
                TextColumn::make('from_email')
                    //->visible(fn($record) => isset($record->data->name))
                    ->getStateUsing(fn($record) => $record->data->email ?? ''),
                TextColumn::make('created_at')
                    ->alignEnd()
            ]);
    }
}