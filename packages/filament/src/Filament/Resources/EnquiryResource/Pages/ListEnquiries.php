<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages;

use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListEnquiries extends ListRecords
{
    protected static string $resource = EnquiryResource::class;

    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
