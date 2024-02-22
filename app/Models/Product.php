<?php

namespace App\Models;

use App\Helpers\FolderHelper;
use App\Helpers\StorageHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Product extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $table = 'products';

    protected $fillable = [
        'code',
        'category',
        'name',
        'description',
        'selling_price',
        'special_price',
        'status',
        'is_delivery_available',
        'image',
        'created_by',
        'edited_by',
        'deleted_by'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['code', 'category', 'name', 'description', 'selling_price', 'special_price', 'status', 'is_delivery_available', 'image'])
            ->setDescriptionForEvent(fn(string $eventName) => "You have {$eventName} product")
            ->useLogName('product')
            ->logOnlyDirty();
    }

    public function productAttributes()
    {
        return $this->hasMany(Attribute::class, 'product_id', 'id');
    }

    public function getImageAttribute($value)
    {
        if ($value != null)
            return (new StorageHelper(FolderHelper::PRODUCT, $value))->getUrl();
        else
            return null;
    }
}
