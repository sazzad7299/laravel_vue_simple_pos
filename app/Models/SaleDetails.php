<?php

namespace App\Models;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SaleDetails extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sale_details';

    protected $primaryKey = 'id';

    protected $fillable = [
        'sale_id',
        'product_id',
        'price',
        'quantity',
        'subtotal',
        'discount',
        'tax',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
