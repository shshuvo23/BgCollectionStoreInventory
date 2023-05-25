<?php

namespace App\Listeners;

use Carbon\Carbon;
use App\Events\LoginHistory;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class storeUserLoginHistory
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
     * @param  \App\Events\LoginHistory  $event
     * @return void
     */
    public function handle(LoginHistory $event)
    {
        $currentTimeStamp = Carbon::now()->toDateTimeString();
        $userInfo = $event->user;

        $saveHistory = DB::table('login_history')->insert([
            'name' => $userInfo->name,
            'email' => $userInfo->email,
            'created_at' => $currentTimeStamp,
            'updated_at' => $currentTimeStamp
        ]);

        return $saveHistory;
    }
}
