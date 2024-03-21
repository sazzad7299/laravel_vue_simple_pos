<?php

namespace App\Services;

use App\Models\Product;

class SaleService
{
    use ImageUpload;
    public function store($request, $product)
    {
        $requestData = $request->all();
        
        $product->fill($requestData)->save();
    }
    public static function index($request)
    {
        $products = Product::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest()->paginate(request()->get('per_page', 1));
        $products->getCollection()->transform(function ($product) {
            $discountAmount = $product->selling_price * ($product->discount / 100);
            $vatAmount = $product->selling_price * ($product->tax / 100);
            $product->discount_amount = $discountAmount;
            $product->vat_amount = $vatAmount;

            return $product;
        });

        return $products;
    }
}
