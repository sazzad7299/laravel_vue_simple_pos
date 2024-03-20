<?php

namespace App\Models;

use App\Traits\CreatedUpdatedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use  HasFactory, SoftDeletes;

    protected $table = 'products';

    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
        'sku',
        'unit',
        'unit_value',
        'selling_price',
        'purchase_price',
        'discount',
        'tax',
        'image',
        'status'
    ];
    public function scopeSearch($query, $request)
    {
        return $query->where('sku', 'LIKE', '%'.$request.'%')
            ->orWhere('name', 'LIKE', '%'.$request.'%');
    }
}
