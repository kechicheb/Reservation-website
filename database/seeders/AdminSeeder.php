<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $data = [
            [
                'matricule'=>'123456789',
                'nom_prenom'=>'Admin',
                'telephone'=>'098765432123445',
                'email'=>'admin@gmail.com',
                'password'=>\Hash::make('Aqwzsxedc@1212@'),
            ],[
                'matricule'=>'1234567890',
                'nom_prenom'=>'Admin',
                'telephone'=>'098765432123445',
                'email'=>'admin1@gmail.com',
                'password'=>\Hash::make('Zsxedcrfv@1313@'),
            ],[
                'matricule'=>'12345678900',
                'nom_prenom'=>'Admin',
                'telephone'=>'098765432123445',
                'email'=>'admin2@gmail.com',
                'password'=>\Hash::make('Edcrfvtgb@1414@'),
            ]
        ];

        Admin::insert($data);



    }

}