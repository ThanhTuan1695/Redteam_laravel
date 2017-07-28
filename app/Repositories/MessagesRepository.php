<?php

namespace App\Repositories;

use App\Helpers\Emojis;
use App\Helpers\Youtube;
use App\Models\Messages;
use Illuminate\Support\Facades\Auth;
use InfyOm\Generator\Common\BaseRepository;
use LRedis;

class MessagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'user_id',
        'messageable_id',
        'messageable_type'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Messages::class;
    }

    public function insertChat($data, $object)
    {
        $mes = new Messages();
        $mes->user_id = Auth::user()->id;
        $mes->content = $data['messages'];
        $mes = $object->messages()->save($mes);
        $listYTB = Youtube::getLinkYTB($data['messages']);
        if ($listYTB != null) {
            foreach ($listYTB as $ytbUrl) {
                $idYTB = Youtube::youtube_id_from_url($ytbUrl);
                $media = new \App\Models\Media();
                $media->name = 'youtube';
                $media->url = $idYTB;
                $media->type = 'ytb';
                $media->mgs_id = $mes->id;
                $object->medias()->save($media);
            }
        }
    }

    public function sendMessage($data, $type)
    {
        $message = Messages::with('user')->orderBy('id', 'desc')->first();
        if (file_exists(public_path() . '/backend/images/upload/' . $message->user->avatar)) {
            $avatar = $message->user->avatar;
        } else {
            $avatar = null;
        }

        if ($avatar == null)
            $img = "<img style='max-width:45px;height:auto;' class='img-circle' src='" . url('/backend/no_image.jpg') . "' />";
        else {
            $img = "<img style='max-width:45px;height:auto;' class='img-circle' src='" . url('/backend/images/upload/' . $avatar) . "'/>";
        }
        $content = "<div class='client'>"
            . $img .
            "<span style='font-weight:bold'>" . Auth::user()->username . "</span>
                    <span>$message->creat_at</span>
                    <p>" . Emojis::Smilify($message->content) . " </p>";
        $list_media = "";
        foreach ($message->media as $media) {
            $content .= Youtube::embededYTB($media->url, true);
            $list_media .= "<li>"
                . Youtube::embededYTB($media->url, false) .
                "</li>";
        }
        $content .= "</div>";

        $data = [
            'content' => $content,
            'messagesType' => $type,
            'idChannel' => $data['id'],
            'sender_id' => Auth::user()->id,
            'content_notice' => $data['messages'],
            'usernameSender' => Auth::user()->username,
        ];
        LRedis::publish('message', json_encode($data));
        return $data = [
            'message' => $content,
            'list_media' => $list_media,
        ];
    }
}
