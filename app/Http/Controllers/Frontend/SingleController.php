<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Messages;
use App\Models\Rooms;
use App\Models\Single;
use App\Repositories\MessagesRepository;
use App\Repositories\SingleRepository;
use App\Repositories\UserRepository;
use Auth;
use DB;
use Goutte\Client;
use Illuminate\Broadcasting\connection;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use LRedis;
use Reponse;

class SingleController extends Controller
{
    private $userRepository;
    private $messagesRepository;
    private $singleRepository;

    public function __construct(UserRepository $userRepo, MessagesRepository $mesRepo, SingleRepository $singleRepo)
    {
        $this->userRepository = $userRepo;
        $this->messagesRepository = $mesRepo;
        $this->singleRepository = $singleRepo;
    }

    public function index($id)
    {

        $user = $this->userRepository->getUserById($id);  
        if ($user == null) {
            return back();
        }
        $user_user = $this->singleRepository->findSingleId(Auth::user()->id,$id);
        if ($user_user == null) {
            $user_user = $this->singleRepository->addSingleId(Auth::user()->id, $id);
        }
        $messages = $user_user->messages;
        $receiver_id = $id;
        $type = "user-user";
        $url = url('public/sendmessageuser');
        $medias = $user_user->medias()->get(['url', 'type'])->unique('url');
        return view('frontend.single.chatUser', compact('user', 'messages', 'type','url','medias','receiver_id'))->with('id', $user_user->id);

    }

    public function sendMessage(Request $request)
    {
        $user_user = Single::find($request['id']);
        $this->messagesRepository->insertChat($request, $user_user);
        $data = $this->messagesRepository->sendMessage($request, 'user-user');
        return $data;
    }


     public function previewUrl(Request $request){
        $content = $request->content;
        $urls = preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $content, $match);
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
         if (count($results) > 0 ) {
             return response()->json(['success' => true, 'data' => $results]);
         }

         return response()->json(['success' => false, 'data' =>$results]);
    }


}
