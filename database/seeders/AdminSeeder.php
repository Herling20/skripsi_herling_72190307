<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admn = [
            [
            'nidn'=>'528126201',
            'nama'=>'Wimmie Handiwidjojo',
            'email'=>'admin@staff.ukdw.ac.id',
            'foto'=>'528126201.png',
            'password'=> bcrypt('admin'),
            ],
        ];

        foreach($admn as $admin)
        {
            Admin::create($admin);
        }
    }
}
