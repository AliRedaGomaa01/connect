<?php 
namespace App\Services;

use App\Models\Image;

class SaveImageService
{
    public static function save($request,$dirFolders = '/images/users')
    {
        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $image->move(storage_path('app/public'.$dirFolders), $name);
        $image = new Image();
        $image->user_id = auth()->id();
        $image->file_name = $name;
        $image->dir_folders = $dirFolders;
        $image->save();
        return $image;
    }
}