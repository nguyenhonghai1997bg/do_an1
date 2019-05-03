<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Paymethod\PaymethodRepositoryInterface;
use App\Http\Requests\StorePaymethodRequest;
use App\Http\Requests\UpdatePaymethodRequest;

class PaymethodController extends Controller
{
    protected $paymethodRepository;
    protected $userRepository;

    public function __construct(
        PaymethodRepositoryInterface $paymethodRepository
    )
    {
        $this->paymethodRepository = $paymethodRepository;
    }
    /**
     * show all paymethods
     * @return view
     */
    public function index(Request $request)
    {
        $key = $request->search;
        if (!empty($key)) {
            $paymethods = $this->paymethodRepository->search($key)->orderBy('id', 'DESC')->paginate($this->paymethodRepository->perPage);
        } else {
            $paymethods = $this->paymethodRepository->orderBy('id', 'DESC')->paginate($this->paymethodRepository->perPage);
        }

        return view('admin.paymethods.index', compact('paymethods', 'key'));
    }

    public function destroy($id)
    {
        $paymethod = $this->paymethodRepository->destroy($id);

        return $paymethod;
    }

    public function update(UpdatePaymethodRequest $request, $id)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $paymethod = $this->paymethodRepository->update($data, $id);

        return $paymethod;
    }

    public function store(StorePaymethodRequest $request)
    {
        $data = $request->all();
        $data['slug'] = \Str::slug($request->name, '-');
        $paymethod = $this->paymethodRepository->create($data);

        return $paymethod;
    }
}
