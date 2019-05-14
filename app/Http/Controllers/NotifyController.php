<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notify;

class NotifyController extends Controller
{
    public function allNotifies()
    {
    	$user = \Auth::user();
    	$notifiesUser = Notify::where('to_user', $user->id)->paginate(Notify::PERPAGE_ALL);

    	return view('notifies.all', compact('notifiesUser'));
    }
}
