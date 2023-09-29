<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers;

use Antidote\LaravelForm\Domain\Fields\Field;
use Antidote\LaravelForm\Domain\Fields\SelectField;
use Antidote\LaravelForm\Domain\Fields\TextAreaField;
use Antidote\LaravelForm\Domain\Fields\TextField;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\AssociateAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\TextColumn;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    public static function form(Form $form): Form
    {
        $fields = app()->make('fieldRegistry');
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->required(),
                Select::make('field_type')
                    ->options($fields)
                    ->reactive()
                    ->afterStateUpdated(fn($livewire) => $livewire->mount()),
                Tabs::make('options')
                    ->visible(fn($get) => $get('field_type'))
                    ->columnSpan(2)
                    ->tabs([
                        Tabs\Tab::make('Common')
                            ->schema(
                                array_merge(
                                    [Toggle::make('is_display_field')
                                    ->default(false)],
                                Field::getCommonOptions()
                                )
                            ),
                        Tabs\Tab::make('specific')
                            ->visible(fn($get) => count($get('field_type')::getFieldOptions()))
                            //@todo use a "nice name" field for labeling
                            ->label(fn($get) => $get('field_type') ? class_basename($get('field_type')) : 'nothign yet')
                            ->schema(fn($get) =>
                                $get('field_type') ? $get('field_type')::getFieldOptions() : []
                            )
                    ])
//                    ->schema(function($get) {
//                        return $get('field_type') ? $get('field_type')::getAllOptions() : [];
//                    })
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('field_type'),
                TextColumn::make('order')
            ])
            ->actions([
                EditAction::make('edit'),
                Action::make('move up')
                    ->action(fn($record) => $record->moveOrderUp()),
                Action::make('move down')
                    ->action(fn($record) => $record->moveorderDown())
            ])
            ->headerActions([
                CreateAction::make('associate')
            ])
            ->defaultSort('order');
    }
}