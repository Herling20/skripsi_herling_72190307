<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Milestone;
use App\Models\Bimbingan;
use App\Models\TahunAjaran;
use App\Models\DetailBimbingan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use App\Rules\SisaBobotRule;
use App\Rules\EditSisaBobotRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function dashboardDosen() 
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('semester', 'tahun', 'tanggalMulai','tanggalSelesai')
                            ->first();
        // dd($tahunAjaranAktif);

        $dosen_id = Auth::user()->id;
        // $tahun = date('Y');
        // $bulan = date('m');
        // $bulan =[];

        // Ensure that $tahunAjaranAktif is not null before proceeding
        if ($tahunAjaranAktif) {
            $tanggalMulai = Carbon::parse($tahunAjaranAktif->tanggalMulai);
            $tanggalSelesai = Carbon::parse($tahunAjaranAktif->tanggalSelesai);

            // Calculate the difference in months between the two dates
            $bulan = $tanggalMulai->diffInMonths($tanggalSelesai);
        } else {
            // Set a default value or handle the case where $tahunAjaranAktif is null
            $bulan = 0; // or any default value you prefer
        }

        // dd($bulan);

        $angkatans = Mahasiswa::select('angkatan')->distinct()->get();

        $namaMahasiswa = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                        ->join('bimbingan', 'bimbingan.mahasiswa_id' , '=', 'mahasiswas.id')
                        // ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                        ->select('mahasiswas.nama')
                        ->get();
        
        // $dataNamaMhs = $namaMahasiswa->nama;
        // dd($dataNamaMhs);


        $dataAngkatan = [];
        $dataBulan = [];
        $capaianMilestone =[];

        // Data Jumlah Bimbingan Tiap Bulan per Angkatan
        $data['dataJumlahBimbinganPerAngkatan'] = [];

        // foreach ($angkatans as $angkatan) {
        //     $jumlahBimbinganBulanan = [];
        //     for ($i = 1; $i <= $bulan; $i++) { 
        //         $jumlahBimbingan = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id' , '=', 'mahasiswas.id') 
        //                 ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
        //                 ->where('mahasiswas.angkatan', $angkatan->angkatan)
        //                 ->where('bimbingan.dosen_id', $dosen_id)
        //                 ->whereYear('detailbimbingan.tanggalBimbingan', $tahun)
        //                 ->whereMonth('detailbimbingan.tanggalBimbingan', $i)
        //                 ->count('detailbimbingan.bimbingan_id');

        //             $jumlahBimbinganBulanan[] = $jumlahBimbingan;
        //             $dataBulan[] = Carbon::create()->month($i)->translatedFormat('F');
        //         }

        //         $data['dataJumlahBimbinganPerAngkatan'][] = [
        //             'angkatan' => $angkatan->angkatan,
        //             'jumlah_bimbingan_bulanan' => $jumlahBimbinganBulanan,
        //         ];
        // }
        // $tanggalMulai = Carbon::parse($tahunAjaranAktif->tanggalMulai);
        // $bulan[] = $bulan->translatedFormat('F');
        
        foreach ($namaMahasiswa as $namaMhs) {
            $jumlahBimbinganBulanan = [];
            // Parse the 'tanggalMulai' and 'tanggalSelesai' from $tahunAjaranAktif
            $tanggalMulai = Carbon::parse($tahunAjaranAktif->tanggalMulai);
            $tanggalSelesai = Carbon::parse($tahunAjaranAktif->tanggalSelesai);

            // Loop through each month within the date range
            while ($tanggalMulai->lte($tanggalSelesai)) {
            $i = $tanggalMulai->format('n'); // 'n' gets the month without leading zeros

            // Query to get the count of advisories for each month
                $jumlahBimbingan = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                        ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
                        ->where('mahasiswas.nama', $namaMhs->nama)
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->whereYear('detailbimbingan.tanggalBimbingan', $tahunAjaranAktif->tahun)
                        ->whereMonth('detailbimbingan.tanggalBimbingan', $i)
                        ->count('detailbimbingan.bimbingan_id');

                        // dd($jumlahBimbingan);

                // Store the count in an array for each month
                $jumlahBimbinganBulanan[] = $jumlahBimbingan;

                // Assuming $dataBulan[] is declared outside this loop
                $dataBulan[] = $tanggalMulai->translatedFormat('F');

                $dataMahasiswa[] = $namaMhs->nama;

                // Move to the next month
                $tanggalMulai->addMonth();
            }

            // Organize the data for each student
            $data['dataJumlahBimbinganMahasiswa'][] = [
                'namaMahasiswa' => $namaMhs->nama,
                'dataBulan' => $dataBulan,
                'jumlah_bimbingan_bulanan' => $jumlahBimbinganBulanan,
            ];
        }
        // dd($dataMahasiswa);
        // dd($data['dataJumlahBimbinganMahasiswa']);
        $namaMhs = [];
        $series = [];

        if(isset($data['dataJumlahBimbinganMahasiswa'])) {

            $counter = 0;

            foreach ($data['dataJumlahBimbinganMahasiswa'][0]['dataBulan'] as $bln) {
                $dataBulanan = [];
                $dataSeries = [];
                $namaMhs = [];
                foreach ($data['dataJumlahBimbinganMahasiswa'] as $dataJum) {
                    // dd($dataJum);
                    $namaMentah = explode(" ", $dataJum['namaMahasiswa']);
                    if(count($namaMentah) > 1)
                    {
                        array_push($namaMhs, $namaMentah[0]." ".$namaMentah[1]);
                    } else 
                    {
                        array_push($namaMhs, $dataJum['namaMahasiswa']);
                    }
                    array_push($dataBulanan, $dataJum['jumlah_bimbingan_bulanan'][$counter]);
                }
                $counter++;
                $dataSeries[$bln] = $dataBulanan;
                array_push($series, $dataSeries);
            }
        }

        // dd($dataSeries);
        // dd($namaMhs);
        // dd($namaMhs);

        $data['dataAngkatan'] = $dataAngkatan;
        $data['dataBulan'] = $dataBulan;
        // $data['dataNamaMahasiswa'] = $dataMahasiswa;

        // dd($data['dataJumlahBimbinganPerAngkatan']);

        $data['dataJumlahMahasiswa'] = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->groupBy('angkatan')
                        ->select('angkatan', \DB::raw('count(mahasiswas.id) as jumlah_mahasiswa'))
                        ->get();
        // dd($data['dataJumlahMahasiswa']);

        $data['dataWaktubimbingan'] = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                        ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->whereNotNull('detailbimbingan.jamMulai')
                        ->whereNotNull('detailbimbingan.jamSelesai')
                        ->groupBy('mahasiswas.angkatan')
                        ->selectRaw('mahasiswas.angkatan as x, ROUND(AVG(TIME_TO_SEC(TIMEDIFF(detailbimbingan.jamSelesai,
                        detailbimbingan.jamMulai)))) AS y')
                        ->get();
        // dd($data['dataWaktubimbingan']);


        $mahasiswaBimbingan = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                        ->join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                        ->whereNull('periode.tanggalSelesai')
                        ->selectRaw('COUNT(mahasiswas.id) as mahasiswaBimbingan')
                        ->get();

        // $jumlahMilestone = Mahasiswa::join('bimbingan', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
        //                 ->join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
        //                 ->where('bimbingan.dosen_id', $dosen_id)
        //                 ->whereNotNull('periode.tanggalSelesai')
        //                 ->selectRaw('COUNT(mahasiswas.id) as mahasiswaLulus')
        //                 ->get();

        $jumlahMilestone = Dosen::leftJoin('milestones', 'dosens.id', '=', 'milestones.dosen_id')
                        ->leftJoin('bimbingan', 'dosens.id', '=', 'bimbingan.dosen_id')
                        ->where('bimbingan.dosen_id', $dosen_id)
                        ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                        ->select(DB::raw('COUNT(DISTINCT milestones.id) as jumlah_milestone'))
                        ->get();

        // dd($data['dataWaktubimbingan']);
        
        // $data['dataJumlahBimbingan'] = $dataJumlahBimbingan;

        // dd($series);

        foreach ($namaMahasiswa as $nama) {
            // dd($namaMhs);
            // Execute the first query to get milestones
            $mahasiswaId = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                    ->join('bimbingan', 'bimbingan.mahasiswa_id' , '=', 'mahasiswas.id')
                    // ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
                    // ->where('bimbingan.dosen_id', $dosen_id)
                    ->where('mahasiswas.nama', $nama->nama)
                    ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->select('mahasiswas.id')
                    ->first();
            // dd($mahasiswaId);

            $milestones = Milestone::join('dosens', 'dosens.id', '=', 'milestones.dosen_id')
                    ->join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                    ->join('mahasiswas', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    // ->where('mahasiswas.nama', '=', $namaMhs)
                    ->where('mahasiswas.id', '=', $mahasiswaId->id)
                    ->where('milestones.semester', '=', $tahunAjaranAktif->semester)
                    ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->select('milestones.id', 'milestones.dosen_id', 'milestones.namaMilestone')
                    ->get();


            // Execute the second query to get consultation records
            $konsultasiDP1 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    // ->where('mahasiswas.nama', '=', $namaMhs)
                    ->where('mahasiswas.id', '=', $mahasiswaId->id)
                    ->where('milestones.semester', '=', $tahunAjaranAktif->semester)
                    ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();
            // dd($konsultasiDP1);

            // Execute the third query to get consultation records for level_pembimbing = 2
            $konsultasiDP2 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    // ->where('mahasiswas.nama', '=', $namaMhs)
                    ->where('mahasiswas.id', '=', $mahasiswaId->id)
                    ->where('milestones.semester', '=', $tahunAjaranAktif->semester)
                    ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();

            // Combine the two collections based on 'id' (assuming 'id' is the common field)
            $hasil = $milestones->map(function ($item) use ($konsultasiDP1, $konsultasiDP2, $mahasiswaId) {
                $acc_milestone = 0;
                
                $dosen_id = Auth::user()->id;

                $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                        ->select('semester', 'tahun', 'tanggalMulai','tanggalSelesai')
                        ->first();

                // $mahasiswa = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                //         ->join('bimbingan', 'bimbingan.mahasiswa_id' , '=', 'mahasiswas.id')
                //         // ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
                //         ->where('bimbingan.dosen_id', $dosen_id)
                //         ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                //         ->select('mahasiswas.id')
                //         ->get();

                $acc1 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswaId->id)
                        ->select('id')
                        ->where('acc_dp1', '=', 'Setuju')
                        ->where('milestone_id', '=', $item->id);

                $acc2 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswaId->id)
                        ->select('id')
                        ->where('acc_dp2', '=', 'Setuju')
                        ->where('milestone_id', '=', $item->id);
                // dd($acc1);

                if($acc1->count() > 0 && $acc2->count() > 0) {
                    $acc_milestone = 1;
                }
                
                // dd($acc_milestone);
                return $acc_milestone;
                // return $item;
            });
            // dd($hasil);
            $capaianMilestone[] = collect($hasil)->flatten()->sum();
            // $sum = collect($hasil)->flatten()->sum();
            // $sum = collect($hasil)->map(fn(array $items): int => array_sum($items));
            // dd($sum);
            // dd($capaianMilestone);
        }
        // dd($capaianMilestone);
        // dd($hasil);

        return view('dosen.dashboardDosen',[
            'halaman' => 'dashboard',
            'data' => $data,
            'mahasiswaBimbingan' => $mahasiswaBimbingan,
            'jumlahMilestone' => $jumlahMilestone,
            'dataSeries' => $series,
            'capaianMilestone' => $capaianMilestone,
            'namaMahasiswa' => $namaMhs,
            'tahunAjaranAktif' => $tahunAjaranAktif
        ]);
    }

    public function profileDosen() 
    {
        $dosen = Dosen::all(); 
        return view('dosen.profileDosen', [
            'halaman' => 'profil',
            'dosen'=>$dosen
        ]);
    }

    public function uploadFoto(Request $request)
    {

        $request->validate([
                'foto' => 'mimes:jpg,jpeg|required|image|file|max:2048',
            ], [
                'foto' => [
                'mimes:jpg,png,jpeg' => 'File yang dapat di upload bertipe JPG dan JPEG',
                'required' => 'Tidak ada file yang di pilih.',
                'max' => 'Maksimal File yang di upload sebesar 2 mb',
            ],
        ]);

        $foto = $request->foto;
        $extension = $foto->getClientOriginalExtension();
        $namaFoto = Auth::user()->nidn.'.'.$extension;

        if ($request->foto) {
            if ($request->fotoLama) {
                File::delete('image/Dosen/', $request->fotoLama);
            }
            $foto->move('image/Dosen/', $namaFoto);
        }


        $id = Auth::user()->id;
        $dosen = Dosen::findorfail($id);

        $dosen->foto = $namaFoto;

        $dosen->save();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-center')
            ->timeOut(2000)
            ->addSuccess('Foto Profil telah ditambahkan.', 'Berhasil!');

        return redirect()->route('dosen.profil');
    }
    
    public function mahasiswaDosen() 
    {
        $dosen = Auth::user()->id;

        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $mahasiswa = Mahasiswa::leftJoin('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                    ->leftJoin('bimbingan', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->leftJoin('detailbimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                    ->where('bimbingan.dosen_id', '=', $dosen)
                    ->orderby('mahasiswas.angkatan', 'DESC')
                    ->groupBy('mahasiswas.id', 'mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.angkatan', 'mahasiswas.foto')
                    ->select('mahasiswas.id', 'mahasiswas.nim', 'mahasiswas.nama', 'mahasiswas.angkatan', 'mahasiswas.foto',
                    DB::raw('COUNT(detailbimbingan.id) as jumlah_konsultasi'))
                    ->get();

        return view('dosen.mahasiswaDosen', [
            'halaman' => 'mahasiswa',
            'mahasiswa'=>$mahasiswa,
        ]);
    }

    public function detailMahasiswaDosen($id) {
        $periodeMhs = Mahasiswa::join('periode', 'periode.mahasiswa_id', 'mahasiswas.id')
                    ->where('mahasiswas.id', $id)
                    ->select('periode.semester')
                    ->first();
        // dd($periodeMhs);

        $dosenPembimbing1 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('bimbingan.status', '=', 'Aktif')
                    ->where('mahasiswas.id', '=', $id)
                    ->select('dosens.nama')
                    ->get();

        $dosenPembimbing2 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    ->where('bimbingan.status', '=', 'Aktif')
                    ->where('mahasiswas.id', '=', $id)
                    ->select('dosens.nama')
                    ->get();

        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                    ->select('tanggalMulai','tanggalSelesai')
                    ->first();
        
         // Execute the first query to get milestones
         $milestones = Milestone::join('dosens', 'dosens.id', '=', 'milestones.dosen_id')
                    ->join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                    ->join('mahasiswas', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('mahasiswas.id', '=', $id)
                    ->where('milestones.semester', '=', $periodeMhs->semester)
                    ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->select('milestones.id', 'milestones.dosen_id', 'milestones.namaMilestone', 'milestones.bobot')
                    ->get();


         // Execute the second query to get consultation records
         $konsultasiDP1 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('mahasiswas.id', '=', $id)
                    ->where('milestones.semester', '=', $periodeMhs)
                    ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();
         // dd($konsultasiDP1);

         // Execute the third query to get consultation records for level_pembimbing = 2
         $konsultasiDP2 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    ->where('mahasiswas.id', '=', $id)
                    ->where('milestones.semester', '=', $periodeMhs)
                    ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();

         // Combine the two collections based on 'id' (assuming 'id' is the common field)
         $hasil = $milestones->map(function ($item) use ($konsultasiDP1, $konsultasiDP2, $id) {
            $acc_milestone = 0;
            $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                    ->select('tanggalMulai','tanggalSelesai')
                    ->first();
            $acc1 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                    ->where('bimbingan.mahasiswa_id', '=', $id)
                    ->select('id')
                    ->where('acc_dp1', '=', 'Setuju')
                    ->where('milestone_id', '=', $item->id)
                    ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai]);

            $acc2 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                    ->where('bimbingan.mahasiswa_id', '=', $id)
                    ->select('id')
                    ->where('acc_dp2', '=', 'Setuju')
                    ->where('milestone_id', '=', $item->id)
                    ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai]);

            if($acc1->count() > 0 && $acc2->count() > 0) {
                $acc_milestone += $item->bobot;
            }
            $item->konsultasiDP1 = $konsultasiDP1->where('milestone_id', $item->id);
            $item->konsultasiDP2 = $konsultasiDP2->where('milestone_id', $item->id);
            $item->ACC = $acc_milestone;
            return $item;
         });

        $pencapaian = 0;
        $totalBobot = 0;

        foreach ($hasil as $item) {
            $pencapaian += $item->ACC;
            $totalBobot += $item->bobot;
         }

        $pencapaian = round(($pencapaian/$totalBobot)*100);

        return view('dosen.detailMahasiswaDosen', [
            'halaman' => 'mahasiswa',
            'mahasiswa' => Mahasiswa::find($id),
            'dosenPembimbing1' => $dosenPembimbing1,
            'dosenPembimbing2' => $dosenPembimbing2,
            'pencapaian' => $pencapaian,
        ]);
    }

    public function milestoneDosen(Request $request) 
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $dosen = Auth::user()->id;
        $pagination = 7;

        $milestone = Milestone::where('milestones.dosen_id', '=', $dosen)
                ->whereBetween('tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                ->select('milestones.id', 'milestones.namaMilestone', 'milestones.bobot', 'milestones.semester', 'milestones.tanggalBerakhir')
                ->paginate($pagination);
        
        return view('dosen.milestoneDosen', [
            'halaman' => 'milestone',
            'milestone'=>$milestone,
        ])->with('no', ($request->input('page', 1) - 1) * $pagination);
    }
    

    public function saveMilestone(Request $request) 
    { 
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                        ->select('tanggalMulai','tanggalSelesai')
                        ->first();

        $request->validate([
            'namaMilestone' => [
                'required',
                'string',
                Rule::unique('milestones')->where(function ($query) use ($tahunAjaranAktif) {
                    return $query->whereBetween('tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                                ->where('semester', request('semester'))->exists(); 
                }),
            ],
            'bobot' => [
                'required',
                'numeric',
                'max:100',
                // 'total_bobot',
                new SisaBobotRule(),

            ],
            'semester' => 'required',
            'tanggalBerakhir' => 'required',
        ], [
            'namaMilestone.required' => 'Nama Milestone tidak boleh kosong.',
            'namaMilestone.string' => 'Nama Milestone harus berupa huruf.',
            'namaMilestone.unique' => 'Nama Milestone sudah ada dalam database.',
                
            'bobot.required' => 'Bobot tidak boleh kosong.',
            'bobot.numeric' => 'Bobot harus berupa angka.',
            'bobot.max' => 'Bobot tidak boleh lebih dari 100.',

            'semester.required' => 'Semester harus dipilih.',

            'tanggalBerakhir.required' => 'Tanggal Berakhir tidak boleh kosong.',
        ]);



        $milestone = new Milestone;

        $milestone->dosen_id = $request->dosen_id;
        $milestone->namaMilestone = $request->input('namaMilestone');
        $milestone->bobot = $request->input('bobot');
        $milestone->semester = $request->input('semester');
        $milestone->tanggalBerakhir = $request->input('tanggalBerakhir');
        $milestone->save();

        return response() -> json([
            'status' => 'sukses',
            // 'message' => 'Data milestone telah ditambahkan.',
            // 'totalBobotGanjil' => $totalBobotGanjil,
            // 'totalBobotGenap' => $totalBobotGenap,
        ]);

    }

    public function editMilestone(Request $request) 
    {   
        // dd($request->all());
        $request->validate([
            'namaMilestone' => [
                'required',
                'string',
                Rule::unique('milestones')->where(function ($query) {
                    return $query->where('semester', request('semester'))
                    ->where('id', '!=', request('milestone_id'));
                }),
            ],
            'bobot' => [
                'required',
                'numeric',
                'max:100',
                // 'total_bobot',
                new EditSisaBobotRule(),
            ],
            // 'semester' => 'required',
            'tanggalBerakhir' => 'required',
        ], [
            'namaMilestone.required' => 'Nama Milestone tidak boleh kosong.',
            'namaMilestone.string' => 'Nama Milestone harus berupa huruf.',
            'namaMilestone.unique' => 'Nama Milestone sudah ada dalam database.',

            'bobot.required' => 'Bobot tidak boleh kosong.',
            'bobot.numeric' => 'Bobot harus berupa angka.',
            'bobot.max' => 'Bobot tidak boleh lebih dari 100.',

            // 'semester.required' => 'Semester harus dipilih.',

            'tanggalBerakhir.required' => 'Tanggal Berakhir tidak boleh kosong.',
        ]);

        $milestone_id = $request->input('milestone_id');
        
        $milestone = Milestone::findorfail($milestone_id);

        $milestone->namaMilestone = $request->input('namaMilestone');
        $milestone->bobot = $request->input('bobot');
        $milestone->tanggalBerakhir = $request->input('tanggalBerakhir');

        $milestone->save();

        return response() -> json([
            'status' => 'sukses',
        ]);
    }

    public function hapusMilestone($id)
    {
        $milestone = Milestone::findOrfail($id);

        $milestone->delete();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Milestone Berhasil di hapus', 'Hapus');
        
        return redirect()->route('dosen.milestone');


    }

    public function bimbinganDosen(Request $request) 
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $dosen = Auth::user()->id;
        $pagination = 5;
        $detailBimbingan = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                            ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                            ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                            ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                            ->orderby('detailbimbingan.tanggalPengajuan', 'DESC')
                            ->where('dosens.id', '=', $dosen)
                            ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                            ->select('detailbimbingan.id as detailBimbingan_id',
                            'detailbimbingan.deskripsiPengajuan', 'detailbimbingan.tanggalPengajuan',
                            'detailbimbingan.jamMulai', 'detailbimbingan.jamSelesai', 'bimbingan.level_pembimbing',
                            'milestones.namaMilestone', 'mahasiswas.nama as namaMhs', 'detailbimbingan.tanggalBimbingan', 'detailbimbingan.statusBimbingan',)
                            ->paginate($pagination);
                            // dd($detailBimbingan);

        return view('dosen.bimbinganDosen', [
            'halaman' => 'bimbingan',
            'detailBimbingan' => $detailBimbingan,
        ])->with('no', ($request->input('page', 1) - 1) * $pagination);
    }

    public function konfirmasiBimbingan(Request $request)
    {   
        // dd($request);
        if ($request->statusBimbingan == 'Disetujui') {
            $request->validate([
                'tanggalBimbingan' => 'required',
            ], [
                'tanggalBimbingan.required' => 'Tanggal Bimbingan tidak boleh kosong.',
            ]);

            $detailBimbingan_id = $request->input('detailBimbingan_id');
            $detailBimbingan = DetailBimbingan::findorfail($detailBimbingan_id);

            $detailBimbingan->tanggalBimbingan = $request->input('tanggalBimbingan');
            $detailBimbingan->statusBimbingan = $request->statusBimbingan;
            $detailBimbingan->save();

            return response() -> json([
                'status' => 'terima',
            ]);

        } else {

            $detailBimbingan_id = $request->input('detailBimbingan_id');
            $detailBimbingan = DetailBimbingan::findorfail($detailBimbingan_id);

            $detailBimbingan->statusBimbingan = $request->statusBimbingan;
            $detailBimbingan->save();

            return response() -> json([
                'status' => 'tidak_diterima',
            ]);
        }
    }

    public function mulaiBimbingan($id)
    {   
        $mulai = DetailBimbingan::findorfail($id);

        $mulai->jamMulai = Carbon::now();

        $mulai->save();

        return redirect()->route('dosen.bimbingan');
    }

    public function selesaiBimbingan(Request $request)
    {
        if ($request->level_pembimbing == 1) {
             $request->validate([
                'catatanBimbingan' => 'required',
                'acc_dp1' =>'required',

             ], [
                'catatanBimbingan.required' => 'Catatan Bimbingan tidak boleh kosong.',
                'acc_dp1' => 'Konfirmasi Bimbingan belum dipilih.'
             ]);

             $detailBimbingan_id = $request->input('detailBimbingan_id');

             $mulai = DetailBimbingan::findorfail($detailBimbingan_id);

             $mulai->catatanBimbingan = $request->input('catatanBimbingan');
             $mulai->acc_dp1 = $request->input('acc_dp1');
             $mulai->jamSelesai = Carbon::now();

             $mulai->save();

             return response() -> json([
                'status' => 'sukses',
             ]);
        }
        elseif ($request->level_pembimbing == 2) {
            $request->validate([
                'catatanBimbingan' => 'required',
                'acc_dp2' =>'required',

            ], [
                'catatanBimbingan.required' => 'Catatan Bimbingan tidak boleh kosong.',
                'acc_dp2' => 'Konfirmasi Bimbingan belum dipilih.'
            ]);

            $detailBimbingan_id = $request->input('detailBimbingan_id');

            $mulai = DetailBimbingan::findorfail($detailBimbingan_id);

            $mulai->catatanBimbingan = $request->input('catatanBimbingan');
            $mulai->acc_dp2 = $request->input('acc_dp2');
            $mulai->jamSelesai = Carbon::now();

            $mulai->save();

            return response() -> json([
                'status' => 'sukses',
            ]);
        }
    }
}