<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    /**
     * Upload file
     *
     * @param $file
     * @param $dir
     * @return string
     */
    public static function upload($file, $dir){
        if ($file) {
            $name = str_random('16').'_'.$file->getClientOriginalName();
            $file->move($dir, $name);

            return $name;
        }

        return '';
    }
}
