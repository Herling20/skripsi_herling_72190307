<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Mahasiswa;


class MahasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mhs = [
            [
             'nim'=>'72190307',
             'nama'=>'Herling Yan Bridny Kalangi',
             'jenisKelamin'=>'Laki - Laki',
             'ipk'=>'3.68',
             'jumlah_sks'=>'138',
             'angkatan'=>'2019',
             'judul'=>'Visualisasi Kinerja Mahasiswa pada Matakuliah Skripsi Studi Kasus : Program Studi Sistem Informasi UKDW',
             'noHp'=>'087776006567',
             'foto'=>'72190307.jpeg',
             'email'=>'herling.kalangi20@gmail.com',
             'password'=> bcrypt('mahasiswa1'),
            ],

            [
             'nim'=>'72190299',
             'nama'=>'Yanita Prasetya Nugraha',
             'jenisKelamin'=>'Laki - Laki',
             'ipk'=>'3.59',
             'jumlah_sks'=>'135',
             'angkatan'=>'2019',
             'judul'=>'Visualisasi Capaian Mahasiswa Studi Kasus : Program Studi Sistem Informasi UKDW',
             'noHp'=>'082123875',
             'foto'=>'72190299.jpeg',
             'email'=>'yanita@gmail.com',
             'password'=> bcrypt('mahasiswa2'),
            ],
        ];

        foreach($mhs as $mahasiswa)
        {
            Mahasiswa::create($mahasiswa);
        }
    }
}
