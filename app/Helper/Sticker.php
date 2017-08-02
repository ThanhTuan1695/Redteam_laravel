<?php
namespace App\Helpers;

class Sticker
{

    static function embededSticker($id)
    {
        $url = url('storage/sticker');
        return "<img class='sticker drag' id='st".str_random(6)."' src='" . $url . '/' . $id . "' style='width : 80px;' >";
    }
}