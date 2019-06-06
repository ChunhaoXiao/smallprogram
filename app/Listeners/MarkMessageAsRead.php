<?php

namespace App\Listeners;

use App\Events\MessageRead;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class MarkMessageAsRead
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  MessageRead  $event
     * @return void
     */
    public function handle(MessageRead $event)
    {
        $messages = $event->messages;
        $messages->each(function($item){
            if($item->to == Auth::id() && !$item->viewed_at)
            {   
                $item->update(['viewed_at' => time()]);
            }
        });
    }
}
