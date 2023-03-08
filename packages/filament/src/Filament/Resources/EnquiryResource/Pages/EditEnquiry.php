<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages;

use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditEnquiry extends EditRecord
{
    protected static string $resource = EnquiryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
