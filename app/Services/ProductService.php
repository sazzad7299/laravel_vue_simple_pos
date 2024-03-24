<?php

namespace App\Services;

use App\Models\Product;
use App\Traits\ImageUpload;

class ProductService
{
    use ImageUpload;
    public function store($request, $product)
    {
        $requestData = $request->all();
        $images = $request->image;
        if ($images) {
            $requestData['image'] = $this->base64FileStore($images, 'images/product/', rand(10000, 99999));
        }
        $requestData['status'] = $requestData['status'] ? 1 : 0;
        $product->fill($requestData)->save();
    }
    public static function index($request)
    {
        $products = Product::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest()->paginate(request()->get('per_page', 20));
        $products->getCollection()->transform(function ($product) {
            $discountAmount = round($product->selling_price * ($product->discount / 100), 2);
            $vatAmount = round($product->selling_price * ($product->tax / 100), 2);

            $product->discount_amount = $discountAmount;
            $product->vat_amount = $vatAmount;

            return $product;
        });

        return $products;
    }
}
