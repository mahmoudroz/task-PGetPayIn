<?php

function uploadImage($photo_name, $folder)
{
    $image = $photo_name;
    $image_name = rand(1000000,100000000) . sha1(time()) . '.'.$image->extension();
    $destinationPath = public_path('//uploads//'. $folder);
    $image->move($destinationPath, $image_name);
    return $image_name;
}

function deleteFile($photo_name, $folder)
{
    $image_name = $photo_name;
    $image_path = public_path($folder) . $image_name;
    if (file_exists($image_path)) {
        @unlink($image_path);
    }
}