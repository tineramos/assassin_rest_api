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

    // TODO: uncomment routes that when implemented.

    /*
        Generate Application Key
    */
    $app->get('/key', function() {
        return str_random(32);
    });

     /*
       Registration
     */
     $app->get('user/{user_id}', 'UserController@getUser');
     $app->post('user', 'UserController@createUser');
     $app->put('user/{user_id}', 'UserController@updateUser');
     $app->delete('user/{user_id}', 'UserController@deleteUser');

     /*
        Login and Logout
     */
     $app->post('user/login', 'UserController@loginUser');
    //  $app->post('user/logout', 'UserController@lgoutUser');

    /*
      User Profile
    */
     $app->get('profile/{user_id}', 'ProfileController@getProfile');
     $app->get('profileWithGames/{user_id}', 'ProfileController@getProfileWithGames');

     /*
       Games
     */
     $app->get('games', 'GameController@index');
     $app->get('game/gameId/{game_id}/userId/{user_id}', 'GameController@getGameInfo');
     $app->post('game/join', 'GameController@joinGame');
     $app->delete('game/leave/{player_id}', 'GameController@leaveGame');

     /*
        Player
     */
     $app->get('player/{player_id}', 'PlayerController@getPlayer');
     $app->put('player/changeWeapons/{player_id}', 'PlayerController@updateWeapons');
     $app->put('player/changeDefences/{player_id}', 'PlayerController@updateDefences');

     /*
       Game Info: required params - game_id, user_id
     */

     /*
        Game play actions - attack/put up defence
     */
     $app->put('attack', 'GamePlayController@attack');
     $app->put('defend', 'GamePlayController@defend');

     /*
       All Weapons
     */
     $app->get('weapons', 'WeaponsController@index');

     /*
       All Defences
     */
     $app->get('defences', 'DefencesController@index');

     /*
        Notification - just for testing
     */
    //  $app->get('notification', 'PushNotificationController@sendNotificationToDevice');

});
