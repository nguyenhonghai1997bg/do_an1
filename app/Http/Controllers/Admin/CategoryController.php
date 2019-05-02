<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Category\CategoryRepositoryInterface;
use App\Repositories\Catalog\CatalogRepositoryInterface;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

class CategoryController extends Controller
{
    protected $categoryRepository;
    protected $catalogRepository;

    public function __construct(
        CategoryRepositoryInterface $categoryRepository,
        CatalogRepositoryInterface $catalogRepository
    )
    {
        $this->categoryRepository = $categoryRepository;
        $this->catalogRepository = $catalogRepository;
    }
    /**
     * show all categories
     * @return view
     */
    public function index(Request $request)
    {
        $key = $request->search;
        $catalog_id = $request->catalog;
        if (!empty($key) || !empty($catalog_id)) {
            $categories = $this->categoryRepository->search($key, $catalog_id)->orderBy('id', 'DESC')->paginate($this->categoryRepository->perPage);
        } else {
            $categories = $this->categoryRepository->orderBy('id', 'DESC')->paginate($this->categoryRepository->perPage);
        }
        $catalogs = $this->catalogRepository->all(['id', 'name']);

        return view('admin.categories.index', compact('categories', 'key', 'catalogs', 'catalog_id'));
    }

    public function destroy($id)
    {
        $category = $this->categoryRepository->destroy($id);

        return $category;
    }

    public function update(UpdateCategoryRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $category = $this->categoryRepository->update($data, $id);
        $category->load('catalog');

        return $category;
    }

    public function store(StoreCategoryRequest $request)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $category = $this->categoryRepository->create($data);
        $category->load('catalog');

        return $category;
    }
}
