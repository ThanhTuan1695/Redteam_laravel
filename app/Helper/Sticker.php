<?php
namespace App\Helpers;

class Sticker
{

    static function embededSticker($id)
    {
        $url = url('storage/sticker');
        return "<img class='sticker ' id='st".str_random(6)."' src='" . $url . '/' . $id . "' style='width : 80px;' >";
    }
}