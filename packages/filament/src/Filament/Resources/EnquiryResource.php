<?php

namespace Antidote\LaravelFormFilament\Filament\Resources;

use Antidote\LaravelForm\Models\Enquiry;
Use Antidote\LaravelFormFilament\Filament\Resources\EnquiryResource\Pages;

class EnquiryResource extends \Filament\Resources\Resource
{
    protected static ?string $model = Enquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $navigationGroup = 'Forms';

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEnquiries::route('/'),
            'create' => Pages\CreateEnquiry::route('/create'),
            'edit' => Pages\EditEnquiry::route('/{record}/edit'),
        ];
    }
}