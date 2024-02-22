<?php

namespace App\Http\Controllers\WEB;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCreateRequest;
use App\Http\Requests\ProductEditRequest;
use App\Models\Product;
use App\Repositories\WEB\ProductRepository;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{

    private $repository;

    /**
     * Constructor method for the class.
     *
     * @param ProductRepository $productRepository The product repository object.
     * @return void
     */
    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Renders the index view for the admin products section.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application The view object for the index page.
     */
    public function index()
    {
        return view('admin.products.index');
    }

    /**
     * Create method.
     *
     * Renders the view for creating a new product in the admin panel.
     *
     * @return \Illuminate\View\View The view for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');
    }

    /**
     * Store a new product.
     *
     * @param ProductCreateRequest $request The request object containing the product data.
     *
     * @return \Illuminate\Http\RedirectResponse The redirect response after storing the product.
     */
    public function store(ProductCreateRequest $request)
    {
        return $this->repository->createProduct($request);
    }

    /**
     * Edit a product.
     *
     * @param int $id The ID of the product to edit.
     *
     * @return \Illuminate\Contracts\View\View The view for editing the product.
     */
    public function edit($id)
    {
        $product = Product::with(['productAttributes'])->find($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update a product.
     *
     * @param ProductEditRequest $request The request object containing the updated product data.
     * @param int $id The ID of the product to be updated.
     *
     * @return \Illuminate\Http\RedirectResponse Whether the update was successful or not.
     */
    public function update(ProductEditRequest $request, $id)
    {
        return $this->repository->updateProduct($request, $id);
    }

    /**
     * Delete a product.
     *
     * @param int $id The ID of the product to delete.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        return $this->repository->deleteProduct($id);
    }

    /**
     * Get product data for ajax request.
     *
     * @param \Illuminate\Http\Request $request The request object containing the ajax data.
     *
     * @return \Illuminate\Http\JsonResponse The json response with the product data.
     */
    public function getAjaxProductData(Request $request)
    {

        $searchText = $request->get('search_text') ?? null;
        $sortBy = $request->get('sort_by');

        $model = Product::query()->with(['productAttributes']);

        $model = $model->where(function ($q) use ($searchText) {
            if ($searchText != null) {
                $q->where(function ($query) use ($searchText) {
                    $query->orWhere('name', 'LIKE', '%' . $searchText . '%');
                    $query->orWhere('code', 'LIKE', '%' . $searchText . '%');
                });
            }
        });

        $model = $model->orderBy('selling_price', $sortBy);

        return DataTables::eloquent($model)
            ->editColumn('image', function ($product) {
                return view('admin.products.partials._product_image', compact('product'));
            })
            ->editColumn('name', function ($product) {
                return $product->name;
            })
            ->editColumn('code', function ($product) {
                return $product->code;
            })
            ->editColumn('category', function ($product) {
                return $product->category;
            })
            ->editColumn('selling_price', function ($product) {
                return number_format($product->selling_price, 2, '.', ',');
            })
            ->editColumn('special_price', function ($product) {
                return number_format($product->special_price, 2, '.', ',');
            })
            ->editColumn('status', function ($product) {
                return view('admin.products.partials._status', compact('product'));
            })
            ->addColumn('action', function ($product) {
                return view('admin.products.partials._action', compact('product'));
            })
            ->toJson();
    }
}
