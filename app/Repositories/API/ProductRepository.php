<?php

namespace App\Repositories\API;

use App\Helpers\APIHelper;
use App\Helpers\APIResponseMessage;
use App\Helpers\FolderHelper;
use App\Helpers\StorageHelper;
use App\Models\Attribute;
use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProductRepository
{

    private $service;

    public function __construct(ProductService $productService)
    {
        $this->service = $productService;
    }

    public function getProducts()
    {
        $products = Product::with('productAttributes')->paginate(10);
        return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::SUCCESS_STATUS, 'success', $products);
    }
    public function createProduct($request)
    {
        try {
            $requestData = $request->all();
            DB::beginTransaction();

            $product = $this->service->createProductRecord($requestData);

            if ($request->has('image')) {
                $this->service->uploadProductImage($request->file('image'), $product);
            }

            if (isset($requestData['attribute_name']) && count($requestData['attribute_name']) > 0) {
                $this->service->createProductAttributes($requestData, $product);
            }

            DB::commit();
            return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::CREATED, 'success', $product);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in createProduct API : ', [$e->getMessage()]);
            return APIHelper::responseBuilder(Response::HTTP_INTERNAL_SERVER_ERROR, APIResponseMessage::ERROR_EXCEPTION, 'error');
        }
    }

    public function updateProduct($request, $id)
    {
        try {
            $product = Product::find($id);
            $requestData = $request->all();
            DB::beginTransaction();

            $this->service->updateProductDetails($product, $request->all());
            $product->edited_by = Auth::id();
            $product->update();

            if ($request->has('image')) {
                //remove old image
                if (null != $product->image)
                    (new StorageHelper(FolderHelper::PRODUCT, $product->image))->deleteImage();
                $this->service->uploadProductImage($request->file('image'), $product);
            }

            if (isset($requestData['attribute_name']) && count($requestData['attribute_name']) > 0) {
                //delete old
                Attribute::with([])->where('product_id', '=', $product->id)->delete();
                $this->service->createProductAttributes($requestData, $product);
            }

            DB::commit();

            return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::UPDATED, 'success', $product);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in updateProduct API : ', [$e->getMessage()]);
            return APIHelper::responseBuilder(Response::HTTP_INTERNAL_SERVER_ERROR, APIResponseMessage::ERROR_EXCEPTION, 'error');
        }
    }

    public function deleteProduct($id)
    {
        try {
            DB::beginTransaction();

            Product::with([])->find($id)->update(['deleted_by' => Auth::id()]);
            Product::with([])->find($id)->delete();

            DB::commit();

            return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::DELETED, 'success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::critical('Exception in deleteProduct API : ', [$e->getMessage()]);
            return APIHelper::responseBuilder(Response::HTTP_INTERNAL_SERVER_ERROR, APIResponseMessage::ERROR_EXCEPTION, 'error');
        }
    }
}
