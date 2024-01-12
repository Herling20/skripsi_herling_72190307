<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Dosen;

class DosenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dsn = [
            [
             'nidn'=>'503017001',
             'nama'=>'Yetli Oslan',
             'noHp'=>'08761616161',
             'jenisKelamin'=>'Perempuan',
             'email'=>'yetli@staff.ukdw.ac.id',
             'foto'=>'503017001.png',
             'password'=> bcrypt('dosen1'),
            ],

            [
             'nidn'=>'528126201',
             'nama'=>'Wimmie Handiwidjojo',
             'noHp'=>'08213748474',
             'jenisKelamin'=>'Laki - Laki',
             'email'=>'whanz@staff.ukdw.ac.id',
             'foto'=>'528126201.png',
             'password'=> bcrypt('dosen2'),
            ],
            [
             'nidn'=>'50792382',
             'nama'=>'Katon Wijana',
             'noHp'=>'0812371237',
             'jenisKelamin'=>'Laki - Laki',
             'email'=>'katon@staff.ukdw.ac.id',
             'foto'=>'50792382.png',
             'password'=> bcrypt('dosen3'),
            ]
        ];

        foreach($dsn as $dosen)
        {
            Dosen::create($dosen);
        }
    }
}
