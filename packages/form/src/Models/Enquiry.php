<?php

namespace Antidote\LaravelForm\Models;

use Antidote\LaravelForm\Database\Factories\EnquiryFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enquiry extends Model
{
    use HasFactory;

    protected static function newFactory()
    {
        return new EnquiryFactory();
    }

    protected $fillable = [
        'data',
        'form_id'
    ];

    protected $casts = [
        'data' => 'object'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }
}