<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Image;

class ImageController extends Controller
{
    public function destroy(Request $request, $id)
    {
        $image = Image::findOrFail($id);
        $image->delete();
        if ($request->model == 'product') {
        	\File::delete(public_path('images/products/' . $image->image_url));
        }
        return response()->json(['status' => __('app.deleted')]);
    }
}
