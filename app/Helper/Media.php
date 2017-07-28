<?php
namespace App\Helpers;

class Media
{

    static function embededVideo($id)
    {
        $url = url('storage');
        return " <div class='videoContainer' id='" . $id . "'>  
        <video  id='playerVideo' controls preload='auto' poster='https://s.cdpn.io/6035/vp_poster.jpg' width='380' >
            <source src='" . $url . '/' . $id . ".mp4' type='video/mp4' />
            <p>Your browser does not support the video tag.</p>
        </video>
        <div class='caption'>Prometheus</div>
        <div class='control' >
            <div class='btmControl'>
                <div class='btnPlay buttonVideo' title='Play/Pause video'><span class='icon-play'></span></div>
                <div class='progressBar'>
                    <div class='progressTime'>
                        <span class='bufferBar'></span>
                        <span class='video-timeBar'></span>
                    </div>
                </div>
                <!--<div class='volume' title='Set volume'>
                    <span class='volumeBar'></span>
                </div>-->
                <div class='sound sound2 buttonVideo' title='Mute/Unmute sound'><span class='icon-sound'></span></div>
                <div class='btnFS buttonVideo' title='Switch to full screen'><span class='icon-fullscreen'></span></div>
            </div>
        </div>
    </div>";

    }

    static function embededMusic($id)
    {
        return "<li>
        <div class='container gradient'>
            <div class='player gradient clearfix' id='".$id."'>
                <a class='button gradient' id='play' href='' title=''><span class='glyphicon glyphicon-play' aria-hidden='true'></span></a>
                <a class='button gradient' id='mute' href='' title=''><span class='glyphicon glyphicon-volume-up' aria-hidden='true'></a>
                <input type='range' id='seek' value='0' max=''/>
            </div>
        </div>
    </li>";
    }
}