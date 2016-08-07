<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;


class DatabaseSeeder extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {
        Model::unguard();

        $this->call('DefencesTableSeeder');
        $this->call('WeaponsTableSeeder');
        $this->call('GamesTableSeeder');

        Model::reguard();
    }
}

/**
* Defences Database Seeder
*/
class DefencesTableSeeder extends Seeder
{
    public function run()
    {
        //delete defences table records
        DB::table('defences')->delete();

        //insert some dummy records
        DB::table('defences')->insert(array(
            array('defence_id' => '1', 'defence_name' => 'Body Armour'),
            array('defence_id' => '2', 'defence_name' => 'Shield'),
            array('defence_id' => '3', 'defence_name' => 'Gas Mask'),
            array('defence_id' => '4', 'defence_name' => 'HP Potion'),
            array('defence_id' => '5', 'defence_name' => 'Proximity Detector'),
        ));
    }
}

/**
* Weapons Database Seeder
*/
class WeaponsTableSeeder extends Seeder
{
    public function run()
    {
        //delete weapons table records
        DB::table('weapons')->delete();

        //insert some dummy records
        DB::table('weapons')->insert(array(
            array('weapon_id' => '1', 'weapon_name' => 'Nerf Gun'),
            array('weapon_id' => '2', 'weapon_name' => 'Poison Gas'),
            array('weapon_id' => '3', 'weapon_name' => 'Light Saber'),
            array('weapon_id' => '4', 'weapon_name' => 'Bomb'),
            array('weapon_id' => '5', 'weapon_name' => 'Trip Wire'),
        ));
    }
}

/**
* Users Database Seeder
*/
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        DB::table('users')->insert(array(
            array('user_id' => '1','email' => 'cramos@se15.qmul.ac.uk','code_name' => 'habagat','password' => 'password1','course' => 'Computer Science','age' => '24','height' => '160','gender' => 'f'),
            array('user_id' => '2','email' => 'tine@mail.com','code_name' => 'pringles','password' => 'password1','course' => 'Architecture','age' => '18','height' => '150','gender' => 'f'),
            array('user_id' => '3','email' => 'dean@mail.com','code_name' => 'lunatic','password' => 'password3','course' => 'Computer Science','age' => '30','height' => '180','gender' => 'm'),
            array('user_id' => '4','email' => 'finnbalor@mail.com','code_name' => 'demon','password' => 'password4','course' => 'Architecure','age' => '35','height' => '170','gender' => 'm'),
            array('user_id' => '5','email' => 'ajstyles@mail.com','code_name' => 'phenomenal','password' => 'password5','course' => 'Computer Science','age' => '40','height' => '180','gender' => 'm'),
            array('user_id' => '6','email' => 'deanwinchester@mail.com','code_name' => 'supernatural','password' => 'password6','course' => 'Computer Science','age' => '33','height' => '175','gender' => 'm')
        );
    }
}

/**
* Games Database Seeder
*/
class GamesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('games')->delete();

        DB::table('games')->insert(array(
            array('game_id'=> '1',
            'game_title' => 'Open Game',
            'game_location' => 'Queen Mary, Mile End',
            'game_status' => 'open',
            'max_players' => '2',
            'players_joined' => '0',
            'available_slots' => '0',
            'open_until' => '2016-08-24 00:0:00'),
            array('game_id'=> '2',
            'game_title' => 'Finished Game',
            'game_location' => 'Victoria Park',
            'game_status' => 'finished',
            'max_players' => '2',
            'players_joined' => '0',
            'available_slots' => '0',
            'open_until' => '2016-08-01 00:0:00'),
            array('game_id'=> '3',
            'game_title' => 'Ongoing Game',
            'game_location' => 'Trafalgar Square',
            'game_status' => 'ongoing',
            'max_players' => '2',
            'players_joined' => '0',
            'available_slots' => '0',
            'open_until' => '2016-08-08 00:0:00'),
        ));
    }
}
