<?php

namespace Antidote\LaravelFormFilament\Filament\Resources;

use Antidote\LaravelForm\Models\Enquiry;
use Antidote\LaravelForm\Models\Field;
Use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Psy\Util\Str;

class EnquiryResource extends \Filament\Resources\Resource
{
    protected static ?string $model = Enquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Forms';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(function($record) {
                $record->load('form.fields');
                //dump($record);
                $fields = [];
                foreach($record->form->fields as $field) {
                    $fieldType = $field->field_type;
                    //dump($field->name);
                    $f = $fieldType::getField($field);
                    //dump($f);
                    $fields[] = $fieldType::getField($field)
                        //->statePath('data.'.$field->name)
                        //->model($record)
                        //->dehydrated(false)
                        //->statePath('data.'.$field->name)
                        //->tap(fn($record) => dump($record->data))
                        ->afterStateHydrated(fn($component, $record) => $component->state($record->data->{$field->name}));
//                        ->beforeStateDehydrated(function($record) use ($field) {
//                            dd($record);
//                            $record->data->{$field->name};
//                            $record->save();
//                        });
                }
                return $fields;
            });
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('Details')
                    ->formatStateUsing(function($record) {
                        $record->load('form');
                        return $record->form->name;
                    })
                    ->description(function(Enquiry $record) {
                        $record->load('form');
                        $display_fields = $record->form->fields()->displayed()->get();
                        $output = ['<table>'];
                        foreach($display_fields as $field) {
                            $field_name = \Illuminate\Support\Str::headline($field->name);
                            $output[] = '<tr>';
                            $output[] = '<td>';
                            $output[] = $field_name.": ".$record->data->{$field->name};
                            $output[] = '</td>';
                            $output[] = '</tr>';
                        }
                        $output[] = '</table>';
                        return implode("\n", $output);
                    }),
                TextColumn::make('created_at')
                    ->date('j M Y H:i')
            ])
            ->actions([
                EditAction::make('Edit'),
                DeleteAction::make('Delete'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnquiries::route('/'),
            'create' => Pages\CreateEnquiry::route('/create'),
            'edit' => Pages\EditEnquiry::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}