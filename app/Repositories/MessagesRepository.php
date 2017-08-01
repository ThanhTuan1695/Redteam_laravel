<?php

namespace App\Repositories;

use App\Helpers\Emojis;
use App\Helpers\Media;
use App\Helpers\PreviewURL;
use App\Helpers\Youtube;
use App\Models\Messages;
use Goutte\Client;
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
        $mes->content = $data['message'];
        $mes = $object->messages()->save($mes);
        if($data->hasFile('file')){
            $file = $data->file('file');
            $extensions = array('jpg', 'jpeg', 'png');
            $title = basename($file->getClientOriginalName(), '.'.$file->getClientOriginalExtension());
            $url = 'storage';
            $name = time();
            $fileName=$name . '.'. $file->getClientOriginalExtension();
            $file->move(public_path($url), $fileName);
            $media = new \App\Models\Media();
            $media->name = $title;
            $media->url = $name;
            $media->mgs_id = $mes->id;

            if($file->getClientOriginalExtension() == 'mp4'){
                $media->type = 'video';
                $object->medias()->save($media);
            }
            elseif ($file->getClientOriginalExtension() == 'mp3'){
                $media->type = 'mp3';
                $object->medias()->save($media);
            }
            elseif (in_array($file->getClientOriginalExtension(), $extensions)) {
                $media->type = 'image';
                $media->url = $fileName;
                $object->medias()->save($media);
            }
        }
        $listYTB = Youtube::getLinkYTB($data['message']);
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
        $previewUrl=PreviewURL::getPreviewUrl($message->content);
        $content = "<div class='client'>"
            . $img .
            "<span style='font-weight:bold'>" . Auth::user()->username . "</span>
                    <span>$message->created_at</span>
                    <p>" . Emojis::Smilify($message->content) . " </p>";

        $list_media_ytb = "";
        $list_media_video = "";
        $list_media_mp3 = "";

        foreach ($message->media as $media) {
            if($media->type == 'ytb' ){
                $content .= Youtube::embededYTB($media->url, timagerue);
                $list_media_ytb .= "<li>"
                    . Youtube::embededYTB($media->url, false) .
                    "</li>";
            }
            elseif( $media->type == 'image'){
                $content.=Media::embededPhoto($media->url);
            }
            elseif ($media->type == 'mp3'){
                $list_media_mp3.= $media->name;
                $list_media_mp3.= Media::embededMusic($media->url);
            }
            elseif ($media->type == 'video'){
                $list_media_video.= $media->name;
                $list_media_video.= Media::embededVideo($media->url);
            }

        }
        $content .= $previewUrl;
        $content .= "</div>";
        $data = [
            'content' => $content,
            'messagesType' => $type,
            'idChannel' => $data['id'],
            'sender_id' => Auth::user()->id,
            'content_notice' => $data['message'],
            'usernameSender' => Auth::user()->username,
            'list_media_ytb' => $list_media_ytb,
            'list_media_video' => $list_media_video,
            'list_media_mp3' => $list_media_mp3,
        ];
        LRedis::publish('message', json_encode($data));
        return $data = [
            'message' => $content,
            'list_media_ytb' => $list_media_ytb,
            'list_media_video' => $list_media_video,
            'list_media_mp3' => $list_media_mp3,
        ];
    }

  
}
