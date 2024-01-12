<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['kodeUser'=>'0528126201',
             'nama'=>'Wimmie Handiwidjojo',
             'role'=>'admin',
             'jenis_kelamin'=>'Laki - Laki',
             'email'=>'whanz@staff.ukdw.ac.id',
             'password'=> bcrypt('admin1')
            ],

            ['kodeUser'=>'503017001',
             'nama'=>'Yetli Oslan',
             'role'=>'dosen',
             'jenis_kelamin'=>'Perempuan',
             'email'=>'yetli@staff.ukdw.ac.id',
             'password'=> bcrypt('dosen1')
            ],

            ['kodeUser'=>'72190307',
             'nama'=>'Herling Yan Bridny Kalangi',
             'role'=>'Mahasiswa',
             'jenis_kelamin'=>'Laki - Laki',
             'email'=>'herling.yan@si.ukdw.ac.id',
             'password'=> bcrypt('herling20')
            ]
        ];

        foreach($users as $user)
        {
            User::create($user);
        }
    }
}
