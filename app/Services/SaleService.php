<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Sale;

class SaleService
{
    public static function index($request)
    {
        return Sale::query()
            ->when($request->has('from_date'), function ($query) use ($request) {
                $fromDate = Carbon::parse($request->get('from_date'));

                return $query->whereDate('created_at', '>=', $fromDate);
            })
            ->when($request->has('to_date'), function ($query) use ($request) {
                $toDate = Carbon::parse($request->get('to_date'));

                return $query->whereDate('created_at', '<=', $toDate);
            })
            ->latest()
            ->paginate(request()->get('per_page', 10));

    }
    public function store($requestData, $sale)
    {
        $sale->fill($requestData)->save();
        return $sale;
    }
    public function show($id){
        $sale = Sale::with('saleDetails:id,product_id,sale_id,quantity,price,subtotal,discount,tax', 'saleDetails.product:id,sku,name',)
        ->findOrFail($id);

     return $sale;
    }
}
