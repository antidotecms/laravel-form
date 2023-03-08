<?php

namespace Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages;

use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource;
use Antidote\LaravelFormFilament\Filament\Resources\FormResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateEnquiry extends CreateRecord
{
    protected static string $resource = EnquiryResource::class;
}
