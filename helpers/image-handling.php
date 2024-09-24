<?php
$image = '';
function processImage($image)
{

    if (!check_file_type($image['type'])) {
        $image['image'] = "Not a valid type image";
        exit;
    }
    // check_file_size($image['size']);

    return $image;
}


// check file type
function check_file_type($type)
{
    $allowedType = ['image/jpeg', 'image/png'];
    return in_array($type, $allowedType);
}


// check file size
function check_file_size($size)
{
    $maxSize = '';
    return $size <= $maxSize;
}
