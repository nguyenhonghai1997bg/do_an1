<?php

namespace App\Repositories\Product;

use App\Repositories\RepositoryEloquent;
use App\Repositories\Product\ProductRepositoryInterface;
use App\Http\Controllers\Traits\FileUploadTrait;
use App\Product;
use DB;
use App\Warehouse;
use App\Sale;


class ProductRepository extends RepositoryEloquent implements ProductRepositoryInterface
{
    use FileUploadTrait;
    public $perPage;

    public function __construct(Product $product)
    {
        $this->model = $product;
        $this->perPage = $this->model::PERPAGE;
    }

    public function search($key, $category_id)
    {
        if ($category_id) {
            return $this->model->where('category_id', $category_id)->where(function($query) use ($key) {
                $query->where('name', 'like', '%' . $key . '%')->orWhere('description', 'like', '%' . $key . '%');
            });
        } else {
            return $this->model->where('name', 'like', '%' . $key . '%')->orWhere('description', 'like', '%' . $key . '%');
        }
    }

    public function store($dataSale, $dataWarehouse, $dataProduct, $dataImages)
    {
        DB::beginTransaction();
        try {
            $sale_id = null;
            if ($dataSale != null) {
                $sale = Sale::create([
                    'sale_price' => $dataSale['sale_price'],
                    'description' => $dataSale['sale_description'],
                ]);
                $sale_id = $sale->id;
            }
            $warehouse = Warehouse::create($dataWarehouse);
            $dataProduct['sale_id'] = $sale_id;
            $dataProduct['warehouse_id'] = $warehouse->id;
            $product = $this->model->create($dataProduct);
            $images = $this->saveFiles($dataImages, 'products', $product->id);

            DB::commit();
            return $product;
        } catch(Exception $e) {
            DB::rollBack();
        }
    }

    public function updateProduct($id, $dataSale, $dataWarehouse, $dataProduct, $dataImages)
    {
        DB::beginTransaction();
        try {
            $product = $this->model->findOrFail($id);
            $sale_id = null;
            $old_sale = $product->sale;
            if ($dataSale != null) {
                $sale = Sale::updateOrCreate(
                    [
                        'id' => $product->sale->id ?? ''
                    ],
                    [
                        'sale_price' => $dataSale['sale_price'],
                        'description' => $dataSale['sale_description'],
                    ]
                );
                $sale_id = $sale->id;
            }
            $warehouse = $product->warehouse->update($dataWarehouse);
            $dataProduct['sale_id'] = $sale_id;
            $dataProduct['warehouse_id'] = $product->warehouse->id;
            $product->update($dataProduct);
            if ($dataImages != null) {
                $images = $this->saveFiles($dataImages, 'products', $product->id);
            }

            if ($dataSale == null) {
                if ($old_sale) {
                    $old_sale_id = $product->sale->id;
                    Sale::destroy($old_sale_id);
                }
            }

            DB::commit();
            return $product;
        } catch(Exception $e) {
            DB::rollBack();
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = $this->model->findOrFail($id);
            $images = $product->images;
            foreach ($images as $key => $image) {
                \File::delete(public_path('images/products/' . $image->image_url));
            }
            $this->model->destroy($id);
            DB::commit();

            return;
        } catch (Exception $e) {
            DB::rollBack();
        }
    }

    public function changeStatus($request, $id)
    {
        $product = $this->findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return $product;
    }

    public function latestProducts()
    {
        $products = $this->model->orderBy('id', 'DESC')->limit(8)->get();

        return $products;
    }

    public function topviewtProducts()
    {
        $products = $this->model->orderBy('view', 'DESC')->limit(8)->get();

        return $products;
    }

    public function topSale()
    {
        $products = $this->model->whereNotNull('sale_id')->with(['sale' => function($query) {
            $query->orderBy('sale_price');
        }])->limit(3)->get();

        return $products;
    }

    public function moreProduct($id, $price, $category_id)
    {
        return $this->model->where('id', '!=', $id)->where(function($query) use ($price, $category_id){
            $query->where('price', $price)->orWhere('category_id', $category_id);
        })->limit(4)->get();
    }
}
