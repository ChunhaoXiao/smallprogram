<?php

namespace App\Listeners;

use App\Events\MemberViewed;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Auth;

class UpdateViewHistory
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
     * @param  MemberViewed  $event
     * @return void
     */
    public function handle(MemberViewed $event)
    {
        $user = Auth::user();
        $viewed_user = $event->user;
        if($row = $user->viewers()->where('viewed_id', $viewed_user->id)->first())
        {
            return $row->increment('numbers');
        }
        return $user->viewers()->create(['viewed_id' => $viewed_user->id]);
    }
}
