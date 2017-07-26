<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use Auth;
class ListUsers extends AbstractWidget
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
        //
        $currentUser = Auth::user();
        if(!empty($currentUser)){
            $listUserPL = \App\Models\User::all();
        }
        return view('frontend.widgets.list_users', [
            'config' => $this->config,
            'listUserPL' => $listUserPL,
        ]);
    }
}
