<?php

namespace App\Helpers;

class Youtube
{
    static function youtube_id_from_url($url)
    {
        $pattern =
            '%^# Match any youtube URL
        (?:https?://)?  # Optional scheme. Either http or https
        (?:www\.)?      # Optional www subdomain
        (?:             # Group host alternatives
          youtu\.be/    # Either youtu.be,
        | youtube\.com  # or youtube.com
          (?:           # Group path alternatives
            /embed/     # Either /embed/
          | /v/         # or /v/
          | /watch\?v=  # or /watch\?v=
          )             # End path alternatives.
        )               # End host alternatives.
        ([\w-]{10,12})  # Allow 10-12 for 11 char youtube id.
        $%x';
        $result = preg_match($pattern, $url, $matches);
        if ($result) {
            return $matches[1];
        }
        return false;
    }

    static function getLinkYTB($string)
    {
        preg_match_all('@https?://(www\.)?youtube.com/.[^\s.,"\']+@i', $string, $aMatches);
        return $aMatches[0];
    }

    static function embededYTB($id, $isOnly)
    {
        if ($isOnly == false)
            return "<iframe class='yt_players' id='" . $id . "' width='385' height='230' src='http://www.youtube.com/embed/" . $id . "?rel=0&wmode=Opaque&enablejsapi=1'
            frameborder='0' allowfullscreen></iframe>";
        else
            return "<iframe class='yt_players'  width='385' height='230' src='http://www.youtube.com/embed/" . $id . "?rel=0&wmode=Opaque&enablejsapi=1'
            frameborder='0' allowfullscreen></iframe>";
    }
}