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
use Filament\Notifications\Notification;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\AssociateAction;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Unique;

class FieldsRelationManager extends RelationManager
{
    protected static string $relationship = 'fields';

    protected static ?string $title = 'Fields';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Form $form): Form
    {
        $fields = app()->make('fieldRegistry');
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('name')
                    ->unique(callback: function($livewire) {
                        return function($attribute, $value, $fail) use ($livewire) {

                            $existing_names = $livewire->ownerRecord->fields
                                ->pluck('name')
                                ->map(fn($item) => Str::of($item)->lower()->snake())
                                ->toArray();

                            $converted_name = Str::of($value)->lower()->snake();

                            if(in_array($converted_name,$existing_names)) {
                                $fail('The name must be unique in this form');
                            }
                        };
                    })
                    ->required(),
                Select::make('field_type')
                    ->options($fields)
                    ->reactive()
                    ->required()
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
                    ->action(fn($record) => $record->moveorderDown()),
                DeleteAction::make('delete'),
                //@todo potential issue with force deleting and restore in relation managers
//                ForceDeleteAction::make('force_delete')
//                    ->before(function() {
//                        Notification::make()
//                            ->title('Data for this field will be deleted')
//                            ->body('Permanately deleting this field will remove all data related to it. '.
//                                'If the field is no lobger used but you wish to look at historical data, leave this as trashed.'.
//                                'Are you sure you wish to delete the field?')
//                            ->actions([
//                                \Filament\Notifications\Actions\Action::make('Yes'),
//                                \Filament\Notifications\Actions\Action::make('No')
//                            ])
//                            ->send();
//                    }),
//                RestoreAction::make('restore')
            ])
            ->headerActions([
                CreateAction::make('associate')
            ])
            ->filters([
                TrashedFilter::make('trashed')
            ])
            ->defaultSort('order');
    }
}