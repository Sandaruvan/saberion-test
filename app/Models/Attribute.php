<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Attribute extends Model
{
    use HasFactory, LogsActivity;

    protected $table = 'attributes';

    protected $fillable = [
        'product_id',
        'attribute_name',
        'attribute_value'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['product_id', 'attribute_name', 'attribute_value'])
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} attribute")
            ->useLogName('attribute')
            ->logOnlyDirty();
    }
}
