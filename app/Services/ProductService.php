<?php

namespace App\Services;

use App\Helpers\FolderHelper;
use App\Helpers\StorageHelper;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
//product create method
    public function createProductRecord($requestData)
    {
        return Product::create([
            'code' => $requestData['code'],
            'category' => $requestData['category'],
            'name' => $requestData['name'],
            'description' => $requestData['description'],
            'selling_price' => $requestData['selling_price'],
            'special_price' => $requestData['special_price'],
            'status' => $requestData['status'],
            'is_delivery_available' => $requestData['is_delivery_available'],
            'created_by' => Auth::id()
        ]);
    }

//image upload method
    public function uploadProductImage($file, $product)
    {
        $imageName = $file->getClientOriginalName();
        (new StorageHelper(FolderHelper::PRODUCT, $imageName, $file))->uploadImage();
        $product->image = $imageName;
        $product->save();
    }

//product attributes save method
    public function createProductAttributes($requestData, $product)
    {
        for ($i = 0; $i < count($requestData['attribute_name']); $i++) {
            Attribute::create([
                    'product_id' => $product->id,
                    'attribute_name' => $requestData['attribute_name'][$i],
                    'attribute_value' => $requestData['attribute_value'][$i]
                ]
            );
        }
    }

    //update product
    public function updateProductDetails(Product $product, array $requestData)
    {
        $product->code = $requestData['code'];
        $product->category = $requestData['category'];
        $product->name = $requestData['name'];
        $product->description = $requestData['description'];
        $product->selling_price = $requestData['selling_price'];
        $product->special_price = $requestData['special_price'];
        $product->status = $requestData['status'];
        $product->is_delivery_available = $requestData['is_delivery_available'];
    }
}
