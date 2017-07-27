<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;
use App\Models\Rooms;
class ListRooms extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $currentUser = Auth::user();
        if (!empty($currentUser)) {
            if ($currentUser->role == '2') {
                $public = Rooms::where('type','public')->get();
                $private = $currentUser->rooms()->where('type','private')->get();
                $listRoomPL = collect([$public, $private]);
                $listRoomPL = $listRoomPL->collapse();
            } else {
                $listRoomPL = \App\Models\Rooms::all();
            }
        }
        return view('frontend.widgets.list_rooms', [
            'config' => $this->config,
            'listRoomPL' => $listRoomPL,
        ]);
    }
}
