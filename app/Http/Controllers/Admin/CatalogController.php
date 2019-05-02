<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Catalog\CatalogRepositoryInterface;
// use App\Repositories\User\UserRepositoryInterface;
use App\Http\Requests\StoreCatalogRequest;
use App\Http\Requests\UpdateCatalogRequest;

class CatalogController extends Controller
{
    protected $catalogRepository;
    protected $userRepository;

    public function __construct(
        CatalogRepositoryInterface $catalogRepository
        // UserRepositoryInterface $userRepository
    )
    {
        $this->catalogRepository = $catalogRepository;
        // $this->userRepository = $userRepository;
    }
    /**
     * show all Catalogs
     * @return view
     */
    public function index(Request $request)
    {
        $key = $request->search;
        if (!empty($key)) {
            $catalogs = $this->catalogRepository->search($key)->orderBy('id', 'DESC')->paginate($this->catalogRepository->perPage);
        } else {
            $catalogs = $this->catalogRepository->orderBy('id', 'DESC')->paginate($this->catalogRepository->perPage);
        }

        return view('admin.catalogs.index', compact('catalogs', 'key'));
    }

    public function destroy($id)
    {
        $catalog = $this->catalogRepository->destroy($id);

        return $catalog;
    }

    public function update(UpdateCatalogRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $catalog = $this->catalogRepository->update($data, $id);

        return $catalog;
    }

    public function store(StoreCatalogRequest $request)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $catalog = $this->catalogRepository->create($data);

        return $catalog;
    }
}
