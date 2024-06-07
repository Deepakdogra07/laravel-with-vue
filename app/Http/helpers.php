<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('insertData')) {
    function insertData($file, $path)
    {
        $name = uniqid().'_'.time().'_'.'.'.$file->getClientOriginalExtension();
        Storage::disk('public')->put($path.$name, file_get_contents($file));
        $imageName = $path.$name;
        return $imageName;
    }
}


?>