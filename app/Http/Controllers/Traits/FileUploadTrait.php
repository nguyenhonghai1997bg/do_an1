<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Image;
trait FileUploadTrait
{

    /**
     * File upload trait used in controllers to upload files
     */
    public function saveFiles($images, $pathSave, $product_id = null, $belong_to_slide = 0)
    {
        $data = [];
        foreach ($images as $key => $image) {
            if (is_file($image)) {
                $imageName = time(). '.'. $image->getClientOriginalName();
                $path = $image->move(public_path("images/$pathSave"), $imageName);
                $data[] = Image::create([
                    'image_url' => $imageName,
                    'product_id' => $product_id,
                    'belong_to_slide' => $belong_to_slide,
                ]);
            }
        }

        return $data;
    }
}