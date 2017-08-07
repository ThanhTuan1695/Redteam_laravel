<?php
namespace App\Helpers;

use Goutte\Client;


class PreviewURL
{
    static function getPreviewUrl($content)
    {
         $preview =Self::preview($content);
         if ($preview != null) {
            $previewMsg =  '<div class="row" data-miss>'
                  .'<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>'
                                . '<div class="col-md-3">'
                                . '<div style="background: #999;">'
                                . '<img src="' . $preview['image'] . '" width="150" height="180">'
                                . '</div>'
                                . '</div>'
                                . '<div class="col-md-9">'
                                . '<div class="row url-title">'
                                . '<a style="color:green;" href="' . $preview['url'] . '">' . $preview['title'] . '</a>'
                                . '</div>'
                                . '<div class="row url-link">'
                                . '<a href="' . $preview['url'] . '">' . $preview['host'] . '</a>'
                                . '</div>'
                                . '<div class="row url-description">' . $preview['description'] . '</div>'
                                . '</div>'
                                . '</div>';
             return $previewMsg;
         }
        return "";  
    }
    static function preview($msg){
        $arrmsg = explode(" ", $msg);
        $urls = 0;

        foreach ($arrmsg as $check) {
           $urls = preg_match_all('#\bhttp?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', trim($check), $match);
           if ($urls > 0) {
               break;
           }
        }
        $results = [];
        if ($urls > 0) {
            $url = $match[0][0];
            $client = new Client();
            try {
                $crawler = $client->request('GET',$url);
                $status_code= $client->getResponse()->getStatus();
                if ($status_code == 200) {
                    //$crawler->filterXPath("html/head/title")->text();otherwise to take head title
                    $title = $crawler->filter('title')->text();
                    if ($crawler->filterXpath('//meta[@name="description"]')->count()) {
                        $description = $crawler->filterXpath('//meta[@name="description"]')->attr('content');
                    }
                    if ($crawler->filterXpath('//meta[@name="og:image"]')->count()) {
                            $image = $crawler->filterXpath('//meta[@name="og:image"]')->attr('content');
                    } elseif ($crawler->filterXpath('//meta[@name="twitter:image"]')->count()) {
                             $image = $crawler->filterXpath('//meta[@name="twitter:image"]')->attr('content');
                             }else {
                                if ($crawler->filter('img')->count()) {
                                     $image = $crawler->filter('img')->attr('src');
                                 } else {
                                     $image = 'no_image';
                                 }  
                         }
                }
                 $results['title'] = $title;
                 $results['url'] = $url;
                 $results['host'] = parse_url($url)['host'];
                 $results['description'] = isset($description) ? $description : '';
                 $results['image'] = $image;
            } catch (Exception $e) {
                
            }
         }
        return $results;

    }
}