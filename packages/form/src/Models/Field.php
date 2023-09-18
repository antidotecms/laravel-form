<?php

namespace Antidote\LaravelForm\Models;

use Antidote\LaravelForm\Database\Factories\FieldFactory;
//use Antidote\LaravelForm\Models\Concerns\CommonAttributes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class Field extends Model implements Sortable
{
    use HasFactory;
    use SortableTrait;

    public static $modelsShouldPreventAccessingMissingAttributes = true;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true
    ];

    protected static function newFactory()
    {
        return new FieldFactory();
    }

    protected $fillable = [
        'name',
        'field_type',
        'field_attributes',
        'form_id',
        'order'
    ];

    public function fieldType() : Attribute
    {
        return Attribute::make(
            set: function($value) {
                if(is_subclass_of($value, \Antidote\LaravelForm\Domain\Fields\Field::class)) {
                    return $value;
                } else {
                    throw new \Exception('not a valid field type - must extend from \Antidote\LaravelForm\Domain\Fields\Field');
                }
            }
        );
    }

    public function name() : Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::snake($value)
        );
    }

    public function label() : Attribute
    {
        return Attribute::make(
            get: fn($value) => Str::headline($value)
        );
    }

    protected $casts = [
        'field_attributes' => 'array'
    ];

    public function form()
    {
        $this->belongsTo(Form::class);
    }

    public function getAttribute($key)
    {
////        $is_commmon_attribute = in_array($key, $this->common_attributes);
//        $is_database_field = in_array($key, array_keys($this->attributes));
//        $is_attribute_field = $this->getAttributeValue('attributes') && in_array($key, array_keys($this->getAttributeValue('attributes')));
//
////        if($is_commmon_attribute) {
////            return $this->$key;
////        }
//
//        if(!$is_database_field && $is_attribute_field) {
//            return $this->getAttributeValue('attributes')[$key];
//        } elseif ($is_database_field) {
//            return parent::getAttribute($key);
//        } elseif ($is_attribute_field) {
//            return $this->getAttributeValue($key);
//        }
//
//        throw new \Exception('no such field or attribute');

        if (! $key) {
            return;
        }

        if(in_array($key, array_keys($this->attributes))) {
            return $this->getAttributeValue($key);
        }

        if($this->getAttributeValue('field_attributes') && in_array($key, array_keys($this->getAttributeValue('field_attributes')))) {
            return $this->getAttributeValue('field_attributes')[$key];
        }

        if(!$this->getAttributeValue('field_attributes')) {
            return false;
        }

        //throw new \Exception('no such field or attribute \''.$key.'\'');
        $this->getAttributeValue($key);
    }
}