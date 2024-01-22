<?php

namespace App\Http\Controllers;
// namespace Resource\Views\Mahasiswa;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Skripsi;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\Milestone;
use App\Models\Bimbingan;
use App\Models\DetailBimbingan;
use App\Models\TahunAjaran;
use Carbon\Carbon;


class MahasiswaController extends Controller
{
    public function homeMahasiswa(Request $request) 
    {   
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $mahasiswa = Auth::user()->id;
        $periodeMhs = Auth::user()->periode->semester;
        $pagination = 5;

        $dosenPembimbing1 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                            ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                            ->where('bimbingan.level_pembimbing', '=', 1)
                            ->where('bimbingan.status', '=', 'Aktif')
                            ->where('mahasiswas.id', '=', $mahasiswa)
                            ->select('dosens.nama')
                            ->get();
        
        $dosenPembimbing2 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                            ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                            ->where('bimbingan.level_pembimbing', '=', 2)
                            ->where('bimbingan.status', '=', 'Aktif')
                            ->where('mahasiswas.id', '=', $mahasiswa)
                            ->select('dosens.nama')
                            ->get();

        $riwayatBimbingan = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                            ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                            ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                            ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                            ->where('mahasiswas.id', '=', $mahasiswa)
                            ->where('milestones.semester', '=', $periodeMhs)
                            // ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                            ->orderby('detailbimbingan.tanggalPengajuan', 'DESC')
                            ->select('detailbimbingan.id','detailbimbingan.tanggalPengajuan',
                            'milestones.namaMilestone', 'dosens.nama as namaDosen', 'detailbimbingan.tanggalBimbingan',
                            'detailbimbingan.jamMulai', 'detailbimbingan.jamSelesai',
                            'detailbimbingan.statusBimbingan', 'detailbimbingan.catatanBimbingan')
                            ->paginate($pagination);

        // $progressMahasiswa = Mahasiswa::join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
        //                     ->join('detailbimbingan', 'detailbimbingan.bimbingan_id', '=', 'bimbingan.bimbingan_id')
        //                     ->join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
        //                     ->where('mahasiswas.id', '=', $mahasiswa)
        //                     ->where('detailbimbingan.acc_dp1', '=', 'Setuju');
                            // dd($riwayatBimbingan);

        // Execute the first query to get milestones
        $milestones = Milestone::join('dosens', 'dosens.id', '=', 'milestones.dosen_id')
                    ->join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                    ->join('mahasiswas', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->select('milestones.id', 'milestones.dosen_id', 'milestones.namaMilestone', 'milestones.bobot')
                    ->get();


        // Execute the second query to get consultation records
        $konsultasiDP1 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();

        // Execute the third query to get consultation records for level_pembimbing = 2
        $konsultasiDP2 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();

        $acc_milestone = 0;
        // Combine the two collections based on 'id' (assuming 'id' is the common field)
        $hasil = $milestones->map(function ($item) use ($konsultasiDP1, $konsultasiDP2, $tahunAjaranAktif) {
            $acc_milestone = 0;
            $mahasiswa = Auth::user()->id;
            $acc1 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswa)
                        ->select('id')
                        ->where('acc_dp1', '=', 'Setuju')
                        // ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                        ->where('milestone_id', '=', $item->id);

            $acc2 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswa)
                        ->select('id')
                        ->where('acc_dp2', '=', 'Setuju')
                        // ->whereBetween('detailbimbingan.tanggalPengajuan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                        ->where('milestone_id', '=', $item->id);

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
        
        // $pencapaian = round(($pencapaian/$totalBobot)*100);
        if ($totalBobot != 0) {
            $pencapaian = round(($pencapaian / $totalBobot) * 100);
        } else {
            $pencapaian = 0;
        }

        return view('mahasiswa.homeMahasiswa', [
            'halaman' => 'home',
            'dosenPembimbing1' => $dosenPembimbing1,
            'dosenPembimbing2' => $dosenPembimbing2,
            'riwayatBimbingan' => $riwayatBimbingan,
            'hasil' => $hasil,
            'pencapaian' => $pencapaian,
            'tahunAjaranAktif' => $tahunAjaranAktif
        ])->with('no', ($request->input('page', 1) - 1) * $pagination);
    }

    public function profileMahasiswa() 
    {
        $mahasiswa = Mahasiswa::all();
        return view('mahasiswa.profileMahasiswa', [
            'halaman' => 'profil',  
            'mahasiswa'=>$mahasiswa,
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
        $namaFoto = Auth::user()->nim.'.'.$extension;

        if ($request->foto) {
            if ($request->fotoLama) {
                File::delete('image/Mahasiswa/', $request->fotoLama);
            }
            $foto->move('image/Mahasiswa', $namaFoto);
        } 
        

        $id = Auth::user()->id;
        $mahasiswa = Mahasiswa::findorfail($id);

        $mahasiswa->foto = $namaFoto;

        $mahasiswa->save();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-center')
            ->timeOut(2000)
            ->addSuccess('Foto Profil telah ditambahkan.', 'Berhasil!');
        
        return redirect()->route('mahasiswa.profil');
    }

    public function milestoneMahasiswa() 
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                    ->select('tanggalMulai','tanggalSelesai', 'status')
                    ->first();
        // dd($tahunAjaranAktif);

        $mahasiswa = Auth::user()->id;
        $periodeMhs = Auth::user()->periode->semester;

        // dd($periodeMhs);

        // Execute the first query to get milestones
        $milestones = Milestone::join('dosens', 'dosens.id', '=', 'milestones.dosen_id')
                    ->join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                    ->join('mahasiswas', 'bimbingan.mahasiswa_id', '=', 'mahasiswas.id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->select('milestones.id', 'milestones.dosen_id', 'milestones.namaMilestone', 'milestones.tanggalBerakhir')
                    ->get();


        // Execute the second query to get consultation records
        $konsultasiDP1 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();
                    // dd($konsultasiDP1);

        // Execute the third query to get consultation records for level_pembimbing = 2
        $konsultasiDP2 = DetailBimbingan::join('milestones', 'milestones.id', '=', 'detailbimbingan.milestone_id')
                    ->join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    ->where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->where('milestones.semester', '=', $periodeMhs)
                    // ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai,$tahunAjaranAktif->tanggalSelesai])
                    ->get();

        // Combine the two collections based on 'id' (assuming 'id' is the common field)
        $hasil = $milestones->map(function ($item) use ($konsultasiDP1, $konsultasiDP2, $tahunAjaranAktif) {
                $acc_milestone = 0;
                $mahasiswa = Auth::user()->id;
                $acc1 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswa)
                        ->select('id')
                        ->where('acc_dp1', '=', 'Setuju')
                        ->where('milestone_id', '=', $item->id);

                $acc2 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=','detailbimbingan.bimbingan_id')
                        ->where('bimbingan.mahasiswa_id', '=', $mahasiswa)
                        ->select('id')
                        ->where('acc_dp2', '=', 'Setuju')
                        ->where('milestone_id', '=', $item->id);

                if($acc1->count() > 0 && $acc2->count() > 0) {
                    $acc_milestone = 1;
                }
                if($item->tanggalBerakhir < $tahunAjaranAktif->tanggalMulai) {
                    // dd($item->tanggalBerakhir);
                    $expired = true;
                } else {
                    // dd($tahunAjaranAktif->tanggalSelesai);
                    $expired = false;
                }
                $item->expired = $expired;
                $item->konsultasiDP1 = $konsultasiDP1->where('milestone_id', $item->id);
                $item->konsultasiDP2 = $konsultasiDP2->where('milestone_id', $item->id);
                $item->ACC = $acc_milestone;
                return $item;
        });

        $dosenPembimbing1 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->where('bimbingan.level_pembimbing', '=', 1)
                    ->where('bimbingan.status', '=', 'Aktif')
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->select('bimbingan.bimbingan_id', 'dosens.nama')
                    ->get();
                    // dd($dosenPembimbing1);
                    

        $dosenPembimbing2 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                    ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                    ->where('bimbingan.level_pembimbing', '=', 2)
                    ->where('bimbingan.status', '=', 'Aktif')
                    ->where('mahasiswas.id', '=', $mahasiswa)
                    ->select('bimbingan.bimbingan_id', 'dosens.nama')
                    ->get();

        // dd($milestone);
        return view('mahasiswa.milestoneMahasiswa', [
            'halaman' => 'milestone',
            'dosenPembimbing1' => $dosenPembimbing1,
            'dosenPembimbing2' => $dosenPembimbing2,
            'hasil' => $hasil,
            'tahunAjaranAktif' => $tahunAjaranAktif,
        ]);
    }

    public function ajukanBimbingan(Request $request)
    {
        $request->validate([
            'bimbingan_id' => 'required',
            'deskripsiPengajuan' => 'required',
        ], [
            'bimbingan_id.required' => 'Dosen Pembimbing harus di pilih',
            'deskripsiPengajuan.required' => 'Deskripsi Pengajuan tidak boleh kosong.',
        ]);

        $detailBimbingan = new DetailBimbingan;

        $detailBimbingan->bimbingan_id = $request->input('bimbingan_id');
        $detailBimbingan->milestone_id = $request->input('milestone_id');
        $detailBimbingan->tanggalPengajuan = Carbon::now();
        $detailBimbingan->deskripsiPengajuan = $request->input('deskripsiPengajuan');
        $detailBimbingan->statusBimbingan = 'Menunggu';
        // dd($detailBimbingan);

        $detailBimbingan->save();

        return response() -> json([
            'status' => 'sukses',
        ]);

    }

    public function cetakKonsultasi()
    {   
        $mahasiswa = Auth::user()->id;
        $nim = Auth::user()->nim;
        $periodeMhs = Auth::user()->periode->semester;

        $dosen1 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                ->where('bimbingan.level_pembimbing', '=', 1)
                ->where('bimbingan.status', '=', 'Aktif')
                ->where('mahasiswas.id', '=', $mahasiswa)
                ->select('dosens.nama')
                ->get();
                // dd($dosen1);

        $dosen2 = Bimbingan::join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                ->where('bimbingan.level_pembimbing', '=', 2)
                ->where('bimbingan.status', '=', 'Aktif')
                ->where('mahasiswas.id', '=', $mahasiswa)
                ->select('dosens.nama')
                ->get();

        $riwayatBimbingan1 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                ->where('mahasiswas.id', '=', $mahasiswa)
                ->where('bimbingan.level_pembimbing', '=', 1)
                ->where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                ->select('detailbimbingan.tanggalBimbingan', 'detailbimbingan.catatanBimbingan')
                ->get();

        $riwayatBimbingan2 = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                ->join('mahasiswas', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                ->join('dosens', 'dosens.id', '=', 'bimbingan.dosen_id')
                ->where('mahasiswas.id', '=', $mahasiswa)
                ->where('bimbingan.level_pembimbing', '=', 2)
                ->where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                ->select('detailbimbingan.tanggalBimbingan', 'detailbimbingan.catatanBimbingan')
                ->get();

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML(view('mahasiswa.pdf_mahasiswa.logbook', [
            'dosen1'=>$dosen1,
            'dosen2'=>$dosen2,
            'riwayatBimbingan1'=>$riwayatBimbingan1,
            'riwayatBimbingan2'=>$riwayatBimbingan2,
        ]));
        return $mpdf->Output('Kartu_Konsultasi_Skripsi_'.$nim.'.pdf', 'D');
        // $pdf->setPaper('A4', 'potrait');
        // return $pdf->stream('Kartu_Konsultasi_Skripsi_'.$nim.'.pdf');
    }
}
