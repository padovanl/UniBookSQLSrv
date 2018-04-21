<?php

use Illuminate\Database\Seeder;

class ProvaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { #creo utenti ENTITA' = users
      $users = factory(App\User::class, 80)->create();

      #creo pagine ENTITA' = pages
      $pages = factory(App\Page::class, 20)->create();



      DB::table('users')->insert([
        'name' => 'Admin_Name',
        'surname' => 'Admin_Sur',
        'birth_date' => now(),
        'email' => 'gruppo09@gruppo09.com',
        'admin'=> 1,
        'pwd_hash' => password_hash('gruppo09', PASSWORD_DEFAULT),
        'gender' => '1',
        'citta' => 'Ferrara',
        'ban' => 0,
        'id_user' => uniqid(),
        'pic_path' => '/assets/images/facebook1.jpg',
        'confirmed' => 1,
	'created_at' => now(),
	'updated_at' => now(),
      ]);

    }
}
