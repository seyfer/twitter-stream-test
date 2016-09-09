<?php

namespace App\Jobs;

use App\Tweet;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTweet implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $tweet;

    /**
     * Create a new job instance.
     *
     * @param $tweet
     */
    public function __construct($tweet)
    {

        $this->tweet = $tweet;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
//        $tweet = json_decode($this->tweet, true);
//        var_dump($tweet['text']) . PHP_EOL;
//        var_dump($tweet['id_str']) . PHP_EOL;

        $tweet            = json_decode($this->tweet, true);
        $tweet_text       = isset($tweet['text']) ? $tweet['text'] : null;
        $user_id          = isset($tweet['user']['id_str']) ? $tweet['user']['id_str'] : null;
        $user_screen_name = isset($tweet['user']['screen_name']) ? $tweet['user']['screen_name'] : null;
        $user_avatar_url  = isset($tweet['user']['profile_image_url_https']) ? $tweet['user']['profile_image_url_https'] : null;

        if (isset($tweet['id'])) {
            Tweet::create([
                              'id'               => $tweet['id_str'],
                              'json'             => $this->tweet,
                              'tweet_text'       => $tweet_text,
                              'user_id'          => $user_id,
                              'user_screen_name' => $user_screen_name,
                              'user_avatar_url'  => $user_avatar_url,
                              'approved'         => 0
                          ]);
        }
    }
}
