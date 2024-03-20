<?php

namespace App\Services;
use App\Models\Product;
use App\Traits\ImageUpload;

class ProductService
{
    use ImageUpload;
    public  function store($request, $product) {
        $requestData = $request->all();
        $images = $request->image;
        if ($images) {
            $requestData['image'] = $this->base64FileStore($images, 'images/product/', rand(10000, 99999));
        }
        $requestData['status'] = $requestData['status'] ? 1 : 0;
        $product->fill($requestData)->save();
    }
    public static function index($request){
        return Product::query()
            ->when(request()->get('search'), function ($query) {
                return $query->search(request()->get('search'));
            })
            ->latest()->paginate(request()->get('per_page', 10));
    }
}
