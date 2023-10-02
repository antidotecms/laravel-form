<?php

namespace Antidote\LaravelFormFilament\Filament\Resources;

use Antidote\LaravelForm\Domain\Fields\TextField;
use Antidote\LaravelForm\Models\Form;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\EnquiriesRelationManager;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource\RelationManagers\FieldsRelationManager;
use Antidote\LaravelFormFilament\Rules\ArrayContainsEmails;
use Filament\Forms;
use Filament\Resources\Form as FilamentForm;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Validator;

class FormResource extends Resource
{
    protected static ?string $model = Form::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Forms';

    public static function form(Forms\Form$form): Forms\Form
    {
        //@todo find method to include name with email address - maybe use a repeater?
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),
                Forms\Components\Tabs::make('Recipients')
                    ->columnSpan(2)
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('To')
                            ->schema([
                                Forms\Components\Repeater::make('to')
                                    ->columns(2)
                                    ->minItems(1)
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('CC')
                            ->schema([
                                Forms\Components\Repeater::make('cc')
                                    ->columns(2)
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                    ]),
                            ]),
                        Forms\Components\Tabs\Tab::make('BCC')
                            ->schema([
                                Forms\Components\Repeater::make('bcc')
                                    ->columns(2)
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->required(),
                                        Forms\Components\TextInput::make('email')
                                            ->email()
                                            ->required()
                                    ])
                            ])
                    ])
//                        Forms\Components\TagsInput::make('to')
//                            ->rules([
//                                new ArrayContainsEmails()
//                            ])
//                            ->required(),
//                        Forms\Components\TagsInput::make('cc')
//                            ->rules([
//                                new ArrayContainsEmails()
//                            ]),
//                        Forms\Components\TagsInput::make('bcc')
//                            ->rules([
//                                new ArrayContainsEmails()
//                            ])


//                    Forms\Components\KeyValue::make('to')
//                        ->keyLabel('name')
//                        ->valueLabel('email')
//                        ->required()
//                        ->rules([
//                            new ArrayContainsEmails()
//                        ]),
//                    Forms\Components\KeyValue::make('cc')
//                        ->keyLabel('name')
//                        ->valueLabel('email')
//                        ->rules([
//                            new ArrayContainsEmails()
//                        ]),
//                    Forms\Components\KeyValue::make('bcc')
//                        ->keyLabel('name')
//                        ->keyPlaceholder('Name of recipient')
//                        ->valueLabel('email')
//                        ->keyPlaceholder('Email of recipient')
//                        ->rules([
//                            new ArrayContainsEmails()
//                        ])

            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            FieldsRelationManager::class,
            EnquiriesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListForms::route('/'),
            'create' => Pages\CreateForm::route('/create'),
            'edit' => Pages\EditForm::route('/{record}/edit'),
        ];
    }
}
