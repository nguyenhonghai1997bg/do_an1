<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notify;

class NotifyController extends Controller
{
    public function seen($id)
    {
        $notify = Notify::findOrFail($id);
        $notify->status = 1;
        $notify->save();

        return response()->json(['status' => 'success']);
    }

    public function index()
    {
        $notifies = Notify::orderBy('id', 'DESC')->paginate(Notify::PERPAGE_ALL);

        return view('admin.notifies.index', compact('notifies'));
    }
}
