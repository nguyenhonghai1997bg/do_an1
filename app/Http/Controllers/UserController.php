<?php

namespace App\Http\Controllers;
use App\Repositories\User\UserRepositoryInterface;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $user;

    public function __construct(UserRepositoryInterface $user)
    {
        $this->user = $user;
    }
    public function editProfile()
    {
        return view('profile');
    }

    public function updateProfile(Request $request)
    {
        $data = [];
        $request->validate([
            'name' => 'required|min:3|max:191|string',
            'address' => 'required|string|min:6|max:191',
            'phone' => 'regex:/(0)[0-9]{9}/',
        ]);
        $data = $request->only(['name', 'address', 'phone', 'birth_day']);
        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:6|max:191|confirmed',
            ]);
            $data['password'] = \Hash::make($request->password);
        } else {
            $data['password'] = \Auth::user()->password;
        }
        $user = $this->user->update($data, \Auth::user()->id);
        if($request->ajax()) {
            return response()->json(['status' => __('users.updated')]);
        }

        return redirect()->route('users.edit_profile', compact('user'))->with('status', __('users.updated'));
    }
}
