<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\FormResource\Pages;

use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditForm extends EditRecord
{
    protected static string $resource = FormResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
