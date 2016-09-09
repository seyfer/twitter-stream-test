<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::get('/', function () {
    if (Auth::check()) {
        $tweets = App\Tweet::orderBy('created_at', 'desc')->paginate(5);
    } else {
        $tweets = App\Tweet::where('approved', 1)->orderBy('created_at', 'desc')->take(5)->get();
    }

    return view('welcome', ['tweets' => $tweets]);
});

Route::post('approve-tweets', ['middleware' => 'auth', function (Illuminate\Http\Request $request) {
    foreach ($request->all() as $input_key => $input_val) {
        if (strpos($input_key, 'approval-status-') === 0) {
            $tweet_id = substr_replace($input_key, '', 0, strlen('approval-status-'));
            $tweet    = App\Tweet::where('id', $tweet_id)->first();
            if ($tweet) {
                $tweet->approved = (int)$input_val;
                $tweet->save();
            }
        }
    }

    return redirect()->back();
}]);

Auth::routes();

Route::get('/home', 'HomeController@index');
