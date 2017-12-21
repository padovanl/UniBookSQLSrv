<?php

use Illuminate\Database\Seeder;

class UsersTableSeederUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      #----PROVA-----
      #modificare campi degli utenti
      $users = App\User::all();
      foreach ($users as $user) {
          DB::table('users')->update(['surname' => '2']);
    }
  }
}
