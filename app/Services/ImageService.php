<?php 
namespace App\Services;

use App\Models\Image;

class ImageService
{
    public static function save($request,$dirFolders = '/images/users')
    {
        $image = $request->file('image');
        $name = time() . rand(100,10000) . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('app/public'.$dirFolders), $name);
        $image = new Image();
        $image->user_id = auth()->id();
        $image->path = $dirFolders . '/' . $name;
        $image->save();
        return $image;
    }

    public static function delete(?string $path= 'not_set')
    {
        if (file_exists(storage_path('app/public' . $path))) {
            return unlink(storage_path('app/public' . $path));
        }
    }

}