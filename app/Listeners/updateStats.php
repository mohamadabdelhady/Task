<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Http;

class updateStats
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
     * @param  object  $event
     * @return void
     */
    public function handle(\App\Events\updateStats$event)
    {
        $response=[\App\Http\Controllers\posts::class, 'update'];
        Cache::Put ("UsersCount",$response['allUserCount']);
        Cache::Put ("postCount",$response['allPost']);
        Cache::Put ("usersWithZeroPost",$response['usersWithZeroPosts']);
    }
}
