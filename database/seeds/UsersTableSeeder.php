<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #DB::table('students')-> insert([
        #  'name'=>str_random(10),
        #  'surname'=>str_random(10)
        #]);
        $faker = Faker\Factory::create();
        #cambiare 300 con il numero di utenti che si vuole inserire
        for($i = 0; $i < 300; $i++) {
        App\User::create([
            'name' => $faker->firstName,
            'surname' => $faker->lastName,
            'birth_date' => $faker->date($format = 'Y-m-d', $max = 'now'),
            'email' => $faker->safeEmail,
            'roles'=> 0,
            'pwd_hash' => bcrypt('secret'),
            'gender' => $faker->randomElement(['0', '1']),
            'citta' => $faker->randomElement(['Ferrara','Bologna','Firenze','Roma','Milano','Venezia','Londra','Parigi','Berlino','Torino']),
            'ban' => 0,
            'id_user' => uniqid(),
            'pic_path' => $faker->randomElement(['/resouces/assets/images/facebook1.jpg','/resouces/assets/images/facebook2.jpg','/resouces/assets/images/facebook3.jpeg','/resouces/assets/images/facebook4.jpeg','/resouces/assets/images/facebook5.jpeg','/resouces/assets/images/facebook6.jpeg','/resouces/assets/images/facebook7.jpeg']),
            'confirmed' => 1

        ]);
        }
      }
}
