<?php
namespace App\Helpers;
use App\Services\MediaLibrary\UploadImageService;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class UploadHelper
{


//$user->image = UploadHelper::upload('image',$request->image, "uploads/user_images/");
//POSTMAN RAW-dan  melumat gelende
 public static function upload($f, $file, $name, $target_location)
    {
        if (Request::hasFile($f)) {
            $filename = $name . '.' . $file->getClientOriginalExtension();
            $file->move($target_location, $filename);
            return $filename;
        } else {
            return null;
        }
    }
//$user->image = UploadHelper::upload('image', $request->file('image'), 'uploads/user_images/' . time(), 'uploads/user_images');




    public static function uploadBase64($image,$path,$name) : string|null
    {
        $base64Image = $image;

        $extension = explode('/', explode(':', substr($base64Image, 0, strpos($base64Image, ';')))[1])[1];   // .jpg .png .pdf

        $replace = substr($base64Image, 0, strpos($base64Image, ',')+1);

        $image = str_replace($replace, '', $base64Image);

        $image = str_replace(' ', '+', $image);

        $imageName = $name.'.'.$extension;

        $path = $path.$imageName;

        Storage::disk('public')->put($path, base64_decode($image));

        return $imageName;
    }


//$user->image            =    UploadHelper::updateBase64('image',$request->image,public_path('/'.$user->image), 'uploads/user_images/');

    public static function updateBase64($f,$img,$path, $folderPath)
    {

        if ($img) {
            if(File::exists($path))
            {
                File::delete($path);
            }
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode($f.'/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $uniqid = uniqid();
            $file = $folderPath . $uniqid . '.'.$image_type;
            file_put_contents($file, $image_base64);
            return $file;
        } else {
            return null;
        }
    }


    public static function update($f,$img,$path, $folderPath)
    {

        if ($img) {
            if(File::exists($path))
            {
                File::delete($path);
            }
            $image_parts = explode(";base64,", $img);
            $image_type_aux = explode($f.'/', $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $uniqid = uniqid();
            $file = $folderPath . $uniqid . '.'.$image_type;
            file_put_contents($file, $image_base64);
            return $file;
        } else {
            return null;
        }
    }


    public static function deleteFile($location)
    {
        if (File::exists($location)) {
            File::delete($location);
        }
    }


}

