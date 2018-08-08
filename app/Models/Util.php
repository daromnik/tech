<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Util extends Model
{
    /**
     * @param string $str
     * @return string
     */
    public static function strReplaceSlashToDot(string $str)
    {
        return str_replace("/", ".", $str);
    }
}
