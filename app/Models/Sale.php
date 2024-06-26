<?php

namespace App\Models;

use App\Models\SaleDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sales';

    protected $primaryKey = 'id';

    protected $fillable = [
        'subtotal',
        'discount',
        'tax',
        'total',
    ];
    public function saleDetails()
    {
        return $this->hasMany(SaleDetails::class,'sale_id');
    }
}
