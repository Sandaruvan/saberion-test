<?php

namespace App\Http\Controllers\API;

use App\Helpers\APIHelper;
use App\Helpers\APIResponseMessage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Product;
use App\Repositories\API\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProductController extends Controller
{

    private $repository;

    /**
     * Class constructor.
     *
     * @param ProductRepository $productRepository The product repository instance.
     *
     * @return void
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Retrieves all products from the repository.
     *
     * @return \Symfony\Component\HttpFoundation\Response The array of products.
     */
    public function index()
    {
        return $this->repository->getProducts();
    }

    /**
     * Show a specific product.
     *
     * @param int $id The ID of the product to be shown.
     *
     * @return \Symfony\Component\HttpFoundation\Response The JSON response containing the product information.
     */
    public function show($id)
    {
        $product = Product::with(['productAttributes'])->find($id);
        return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::SUCCESS_STATUS, 'success', $product);
    }

    /**
     * Store a newly created product in the repository.
     *
     * @param ProductCreateRequest $request The request containing the product data.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response indicating the result of the operation.
     */
    public function store(ProductCreateRequest $request)
    {
        return $this->repository->createProduct($request);
    }

    /**
     * Edit an existing product in the repository.
     *
     * @param int $id The id of the product to be edited.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response indicating the result of the operation.
     */
    public function edit($id)
    {
        $product = Product::with(['productAttributes'])->find($id);
        return APIHelper::responseBuilder(Response::HTTP_OK, APIResponseMessage::SUCCESS_STATUS, 'success', $product);
    }

    /**
     * Update an existing product in the repository.
     *
     * @param ProductEditRequest $request The request containing the updated product data.
     * @param int $id The ID of the product to be updated.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response indicating the result of the update operation.
     */
    public function update(ProductEditRequest $request, $id)
    {
        return $this->repository->updateProduct($request, $id);
    }

    /**
     * Delete a product from the repository.
     *
     * @param int $id The ID of the product to be deleted.
     *
     * @return \Symfony\Component\HttpFoundation\Response The response indicating the result of the operation.
     */
    public function destroy($id)
    {
        return $this->repository->deleteProduct($id);
    }
}
