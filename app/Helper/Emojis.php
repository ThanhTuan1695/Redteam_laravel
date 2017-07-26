<?php
namespace App\Helpers;

class Emojis
{
    static function Smilify($subject)
    {

        $smilies = array(
            ':|' => 'ops',
            ':(((' => 'cry',
            ':))' => 'haha',
            '<3' => 'beauty',
            '8*' => 'adore',
            ':o' => 'oh',
            'x-)' => 'sexy_girl',
            ';)' => 'look_down',
            '==' => 'surrender',
            ':*' => 'sweet_kiss',
            'X)' => 'sure',
            ':p' => 'dribble',
            '=))' => 'haha',
            ':D' => 'big_smile',
            ':d' => 'big_smile',
            '8)' => 'cool',
            '8-)' => 'cool',
            ':)' => 'smile',
            ':((' => 'sad',
            ':(' => 'too_sad',
            '>"<' => 'angry'
        );
        
        $replace = array();
        foreach ($smilies as $smiley => $imgName) {
            $url = '/emoji/' . $imgName . '.png';
            array_push($replace, '<img src="' . $url . '" alt="' . $imgName . '"  style="width : 20px ; height : 20px;" " />');
        }
        return str_replace(array_keys($smilies), $replace, $subject);

    }
}