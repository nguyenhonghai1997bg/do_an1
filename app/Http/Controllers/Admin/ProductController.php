<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use DB;

class ProductController extends Controller
{
    use FileUploadTrait;
    protected $categoryRepository;
    protected $productRepository;

    public function __construct(ProductRepositoryInterface $product, CategoryRepositoryInterface $category)
    {
        $this->categoryRepository = $category;
        $this->productRepository = $product;
    }

    public function index(Request $request)
    {
        $key = $request->search;
        $category_id = $request->category;
        if (!empty($key) || !empty($category_id)) {
            $products = $this->productRepository->search($key, $category_id)->orderBy('id', 'DESC')->paginate($this->productRepository->perPage);
        } else {
            $products = $this->productRepository->orderBy('id', 'DESC')->paginate($this->productRepository->perPage);
        }
        $categories = $this->categoryRepository->with('catalog')->get();

        return view('admin.products.index', compact('products', 'key', 'categories', 'category_id'));
    }

    public function create()
    {
        $categories = $this->categoryRepository->with('catalog')->get();

        return view('admin.products.create', compact('categories'));
    }

    public function store(StoreProductRequest $request)
    {
        try {
            $dataSale = null;
            if (!empty($request->sale_price)) {
                $dataSale = $request->only(['sale_price', 'sale_description']);
            }
            $dataWarehouse = $request->only(['depot_name', 'quantity']);
            $dataProduct = $request->only(['name', 'price', 'description', 'detail', 'category_id']);
            $dataProduct['slug'] = \Str::slug($request->name, '-');
            $dataImages = $request->images;
            $product = $this->productRepository->store($dataSale, $dataWarehouse, $dataProduct, $dataImages);
            
            return redirect()->route('products.index')->with('status', __('products.created'));
        } catch (Exception $e) {
            abort('404');
        }

    }

    public function edit($id)
    {
        $product = $this->productRepository->with(['images', 'sale', 'warehouse'])->findOrFail($id);
        $categories = $this->categoryRepository->with('catalog')->get();

        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $dataSale = null;
        if (!empty($request->sale_price)) {
            $dataSale = $request->only(['sale_price', 'sale_description']);
        }
        $dataWarehouse = $request->only(['depot_name', 'quantity']);
        $dataProduct = $request->only(['name', 'price', 'description', 'detail', 'category_id']);
        $dataProduct['slug'] = \Str::slug($request->name, '-');
        $dataImages = $request->images;

        $product = $this->productRepository->updateProduct($id, $dataSale, $dataWarehouse, $dataProduct, $dataImages);

        return redirect()->route('products.edit', ['id' => $product->id])->with('status', __('products.updated'));
    }

    public function destroy($id)
    {
        $this->productRepository->destroy($id);

        return response()->json(['stauts' => __('app.deleted')]);
    }

    public function changeStatus(Request $request, $id)
    {
        $product = $this->productRepository->changeStatus($request, $id);

        return response()->json(['status' => 'success']);
    }

    public function show()
    {
        
    }
}
