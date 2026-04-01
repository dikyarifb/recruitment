<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function store_file($file, $path){
        
        $file_name = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $file_ext = $file->getClientOriginalExtension();
        $hash_microtime = substr(md5(microtime()), 15, 5);
        $file_file_name = Str::slug($file_name)."_".$hash_microtime.".".$file_ext;
        
        $save_avatar = \Storage::disk('s3')->putFileAs($path, $file, $file_file_name, 'public');
        return $file_file_name;
    }
}
