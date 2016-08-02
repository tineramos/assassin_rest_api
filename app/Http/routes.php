<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->get('/', function () use ($app) {
    return $app->version();
});

$app->group(['prefix' => 'api/v1/assassin/', 'namespace' => 'App\Http\Controllers'], function($app) {


/*
  Registration
*/
     $app->get('user/{user_id}', 'UserController@getUser');
     $app->post('user/', 'UserController@createUser');
     $app->put('user/{user_id}', 'UserController@updateUser');
     $app->delete('user/{user_id}', 'UserController@deleteUser');

/*
  Games
*/
     $app->get('games', 'GameController@index');
     $app->get('games/{game_id}', 'GameController@getGame');

/*
  Game Info
*/
     $app->get('gameinfo/{game_id}', 'GameInfoController@getGameInfo');

});
