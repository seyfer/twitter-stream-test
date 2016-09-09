<?php
/**
 * Created by PhpStorm.
 * User: seyfer
 * Date: 9/9/16
 */

namespace App;


use App\Jobs\ProcessTweet;
use Illuminate\Foundation\Bus\DispatchesJobs;
use OauthPhirehose;

class TwitterStream extends OauthPhirehose
{
    use DispatchesJobs;

    /**
     * Enqueue each status
     *
     * @param string $status
     */
    public function enqueueStatus($status)
    {
        $this->dispatch(new ProcessTweet($status));
    }
}