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
             //delete defences table records
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
