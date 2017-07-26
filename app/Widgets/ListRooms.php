<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;

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
                $listRoomPL = $currentUser->ownRooms;
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
