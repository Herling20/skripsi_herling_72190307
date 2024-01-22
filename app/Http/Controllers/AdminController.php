<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Validation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\Periode;
use App\Models\Bimbingan;
use App\Models\DetailBimbingan;
use App\Models\Admin;
use App\Models\TahunAjaran;

class AdminController extends Controller
{
    public function dashboardAdmin() 
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $dosens = Dosen::select('id', 'nama')->orderby('id')->get();
        $angkatans = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                    ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                    ->select('angkatan')
                    ->orderby('angkatan', 'DESC')
                    ->distinct()
                    ->get();

        $jumlahMahasiswa = [];
        $namaDosen = [];
        $mahasiswaDosen =[];
        $jumlahBimbinganDosen = [];
        foreach ($angkatans as $angkatan) {
            $jumlahMahasiswaAngkatan = [];
            foreach ($dosens as $dosen) {
                $jumlahMhs = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                    ->join('bimbingan', 'bimbingan.mahasiswa_id' , '=', 'mahasiswas.id' )
                    ->join('dosens', 'dosens.id' , '=', 'bimbingan.dosen_id' )
                    ->where('bimbingan.dosen_id', $dosen->id)
                    ->where('mahasiswas.angkatan', $angkatan->angkatan)
                    ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                    ->groupby('mahasiswas.angkatan')
                    ->count('bimbingan.bimbingan_id');

                $jumlahMahasiswaAngkatan[] = $jumlahMhs;
            }
            $mahasiswaDosen[] = [
                'angkatan' => $angkatan->angkatan,
                'jumlah_mahasiswa' => $jumlahMahasiswaAngkatan
            ];
        }

        foreach($dosens as $dosen) {
            $nama = explode(" ", $dosen->nama);
            $namaDosen[] = $nama[0]." ".$nama[1];
        }

        foreach ($dosens as $dosen) {
            $jumlahBimbinganDsn = DetailBimbingan::join('bimbingan', 'bimbingan.bimbingan_id' , '=', 'detailbimbingan.bimbingan_id' )
                ->join('dosens', 'dosens.id' , '=', 'bimbingan.dosen_id' )
                ->where('bimbingan.dosen_id', $dosen->id)
                ->where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                ->count('detailbimbingan.id');

            $jumlahBimbinganDosen[] = $jumlahBimbinganDsn;
        }
        
        // dd($jumlahBimbinganDosen);

        $data['dataJumlahBimbinganDosen'] = $jumlahBimbinganDosen;
        $data['dataJumlahMahasiswa'] = $mahasiswaDosen;
        $data['namaDosen'] = $namaDosen;

        $mahasiswaBimbingan = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                ->whereNull('periode.tanggalSelesai')
                ->COUNT('mahasiswas.id');

        $jumlahBimbingan = DetailBimbingan::where('detailbimbingan.statusBimbingan', '=', 'Disetujui')
                ->whereBetween('detailbimbingan.tanggalBimbingan', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                ->COUNT('detailbimbingan.id');

        $dosen = Dosen::count();

        return view('admin.dashboardAdmin', [
            'halaman' => 'dashboard',
            'data' => $data,
            'mahasiswaBimbingan' => $mahasiswaBimbingan,
            // 'mahasiswaLulus' => $mahasiswaLulus,
            'jumlahBimbingan' => $jumlahBimbingan,
            'dosen' => $dosen
        ]);
    }

    public function profileAdmin()
    {
        return view('admin.profileAdmin', [
            'halaman' => 'profil',
        ]);
    }

    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'mimes:jpg,png,jpeg|required|image|file|max:2048',
        ], [
            'foto' => [
            'mimes:jpg,png,jpeg' => 'File yang dapat di upload bertipe JPG, PNG, dan JPEG',
            'required' => 'Tidak ada file yang di pilih.',
            'max' => 'Maksimal File yang di upload sebesar 2 mb',
            ],
        ]);

        $foto = $request->foto;
        $extension = $foto->getClientOriginalExtension();
        $namaFoto = Auth::user()->nidn.'.'.$extension;

        if ($request->foto) {
            if ($request->fotoLama) {
                File::delete('image/Admin/', $request->fotoLama);
            }
            $foto->move('image/Admin/', $namaFoto);
        }


        $id = Auth::user()->id;
        $admin = Admin::findorfail($id);

        $admin->foto = $namaFoto;

        $admin->save();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-center')
            ->timeOut(2000)
            ->addSuccess('Foto Profil telah ditambahkan.', 'Berhasil!');

        return redirect()->route('admin.profil');
    }

    public function tahunAjaran()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('admin.tahunAjaran', [
            'halaman' => 'tahun_ajaran',
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    public function aktifTahunAjaran($id)
    {
        $tahunAjaran = TahunAjaran::where('status', '=', 'Aktif')
                    ->select('id')
                    ->first();

        if ($tahunAjaran == null) {
            $aktif = TahunAjaran::findorfail($id);

            $aktif->status = 'Aktif';

            $aktif->save();
        } else {
            $nonAktif = TahunAjaran::findorfail($tahunAjaran->id);

            $nonAktif->status = 'Tidak Aktif';

            $nonAktif->save();

            $aktif = TahunAjaran::findorfail($id);

            $aktif->status = 'Aktif';

            $aktif->save();
        }

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Tahun Ajaran Berhasil di aktifkan', 'Aktivasi');

        return redirect()->route('admin.tahunAjaran');
    }

    public function editTahunAjaran(Request $request, $id)
    {
        // dd($request);
        $tahunAjaran = TahunAjaran::findorfail($id);
        // dd($tahunAjaran);

        $tahunAjaran->tanggalMulai = $request->tanggalMulai;
        $tahunAjaran->tanggalSelesai = $request->tanggalSelesai;

        $tahunAjaran->save();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Tahun Ajaran Berhasil di edit', 'Edit');

        return redirect()->route('admin.tahunAjaran');
    }

    public function hapusTahunAjaran($id)
    {
        $tahunAjaran = TahunAjaran::findOrfail($id);

        $tahunAjaran->delete();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Tahun Ajaran Berhasil di hapus', 'Hapus');

        return redirect()->route('admin.tahunAjaran');
    }

    public function saveTahunAjaran(Request $request)
    {
        $request->validate([
            'semester' => [
                'required',
            ],
            'tahun' => [
                'required',

            ],
            'tanggalMulai' => 'required',
            'tanggalSelesai' => 'required',
        ], [
            'semester.required' => 'Semester harus dipilih.',

            'tahun.required' => 'Tahun tidak boleh kosong.',

            'tanggalMulai.required' => 'Tanggal Mulai tidak boleh kosong.',

            'tanggalSelesai.required' => 'Tanggal Selesai tidak boleh kosong.',
        ]);

        $tahunAjaran = new TahunAjaran;

        $tahunAjaran->semester = $request->input('semester');
        $tahunAjaran->tahun = $request->input('tahun');
        $tahunAjaran->tanggalMulai = $request->input('tanggalMulai');
        $tahunAjaran->tanggalSelesai = $request->input('tanggalSelesai');
        $tahunAjaran->status = 'Tidak Aktif';
        $tahunAjaran->save();

        return response() -> json([
            'status' => 'sukses',
        ]);
    }

     //--- Data Mahasiswa ---//
    public function dataMahasiswa(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                            ->select('tanggalMulai','tanggalSelesai')
                            ->first();

        $pagination = 7;
        $mahasiswa = Mahasiswa::leftJoin('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                ->leftJoin('bimbingan', 'mahasiswas.id', '=', 'bimbingan.mahasiswa_id')
                ->leftJoin('detailbimbingan', 'bimbingan.bimbingan_id', '=', 'detailbimbingan.bimbingan_id')
                // ->whereBetween('periode.tanggalMulai', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                ->groupBy('mahasiswas.id', 'mahasiswas.nim', 'mahasiswas.nama')
                ->select('mahasiswas.id', 'mahasiswas.nim', 'mahasiswas.nama',
                DB::raw('COUNT(CASE WHEN detailbimbingan.statusBimbingan = "Disetujui" THEN detailbimbingan.id ELSE NULL
                END) as jumlah_konsultasi'))
                ->paginate($pagination);

        $dosen1 = Dosen::join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                ->where('bimbingan.level_pembimbing', '=', 1)
                ->get();

        $dosen2 = Dosen::join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                ->where('bimbingan.level_pembimbing', '=', 2)
                ->get();

        $dataMahasiswa = $mahasiswa->map(function ($item) use ($dosen1, $dosen2) {
                $item->dosen1 = $dosen1->where('mahasiswa_id', $item->id);
                $item->dosen2 = $dosen2->where('mahasiswa_id', $item->id);
                return $item;
        });

        return view('admin.dataMahasiswaAdmin', [
            'halaman' => 'dataMahasiswa',
            'dataMahasiswa'=> $dataMahasiswa,
            'mahasiswa' => $mahasiswa,
        ])->with('no', ($request->input('page', 1) - 1) * $pagination);
    }

    public function tambahDataMahasiswa()
    {
        $dosen = Dosen::all();
        return view('admin.tambahDataMahasiswa', [
            'halaman' => 'dataMahasiswa',
            'dosen' => $dosen
        ]);
    }

    public function saveDataMahasiswa(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'nim' => 'required|min:8',
            'judul' => 'required|min:15',
            'angkatan' => 'required|between:4,4',
            'semester' => 'required',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
            'noHp' => 'required',
            'jenisKelamin' => 'required',
            'jumlah_sks' => 'required|between:1,3',
            'ipk' => 'required',
            'dosen_id1' => 'required|different:dosen_id2',
            'dosen_id2' => 'required|different:dosen_id1',
        ], [
            'nama' => [
                'required' => 'Nama belum terisi.',
                'min' => 'Isi dengan nama lengkap.',
            ],
            'nim' => [
                'required' => 'NIM belum terisi.',
                'min' => 'NIM minimal 8 karakter.',
            ],
            'judul' => [
                'required' => 'Judul Skripsi belum terisi.',
                'min' => 'Judul Skripsi minimal 15 karakter.',
            ],
            'angkatan' => [
                'required' => 'Angkatan belum terisi',
                'between' => 'Isi Angkatan dengan benar.',
            ],
            'semester' => [
                'required' => 'Semester belum di pilih.',
            ],
            'email' => [
                'required' => 'Email belum terisi.',
                'email' => 'Email tidak dapat divalidasi !',
            ],
            'password' => [
                'required' => 'Password belum terisi.',
                'min' => 'Password minimal 5 karakter.',
            ],
            'noHp' => [
                'required' => 'No Handphone belum terisi.',
            ],
            'jenisKelamin' => [
                'required' => 'Jenis Kelamin belum di pilih.',
            ],
            'jumlah_sks' => [
                'required' => 'Jumlah SKS belum terisi.',
                'between' => 'Isi Jumlah SKS dengan benar.',
            ],
            'ipk' => [
                'required' => 'IPK belumi terisi.',
            ],
            'dosen_id1' => [
                'required' => 'Dosen Pembimbing 1 belum di pilih',
                'different' => 'Dosen Pembimbing 1 sama dengan Dosen Pembimbing 2',
            ],
            'dosen_id2' => [
                'required' => 'Dosen Pembimbing 2 belum di pilih',
                'different' => 'Dosen Pembimbing 2 sama dengan Dosen Pembimbing 1',
            ],

        ]);

        $mahasiswa = new Mahasiswa;

        $mahasiswa->nim = $request->nim;
        $mahasiswa->nama = $request->nama;
        $mahasiswa->judul = $request->judul;
        $mahasiswa->angkatan = $request->angkatan;
        $mahasiswa->email = $request->email;
        $mahasiswa->password = bcrypt($request->password);
        $mahasiswa->noHp = $request->noHp;
        $mahasiswa->jenisKelamin = $request->jenisKelamin;
        $mahasiswa->jumlah_sks = $request->jumlah_sks;
        $mahasiswa->ipk = $request->ipk;

        $mahasiswa->save();

        $mahasiswa_id = Mahasiswa::where('mahasiswas.nim', '=', $request->nim)
                    ->select('mahasiswas.id')
                    ->first();
        
        $periode = new Periode;

        $periode->mahasiswa_id = $mahasiswa_id->id;
        $periode->semester = $request->semester;
        $periode->tanggalMulai = Carbon::now();

        $periode->save();

        $dosen1 = new Bimbingan;

        $dosen1->mahasiswa_id = $mahasiswa_id->id;
        $dosen1->dosen_id = $request->dosen_id1;
        $dosen1->status = "Aktif";
        $dosen1->level_pembimbing = 1;
        $dosen1->create_at = Carbon::now();
       
        $dosen1->save();

        $dosen2 = new Bimbingan;

        $dosen2->mahasiswa_id = $mahasiswa_id->id;
        $dosen2->dosen_id = $request->dosen_id2;
        $dosen2->status = "Aktif";
        $dosen2->level_pembimbing = 2;
        $dosen2->create_at = Carbon::now();

        $dosen2->save();

        sweetalert()
            ->timerProgressBar(false)
            ->timer(3000)
            ->showConfirmButton(
                $showConfirmButton = true,
                $confirmButtonText = 'Kembali',
                $confirmButtonColor = "#1A73E8")
            ->addSuccess('Data Mahasiswa berhasil ditambahkan.');
            
        return redirect()->route('admin.dataMahasiswa');

    }

    public function detailDataMahasiswa($id)
    {
        // dd($mahasiswa);
        $dosen1 = Dosen::join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                ->where('bimbingan.mahasiswa_id', '=', $id)
                ->where('bimbingan.level_pembimbing', '=', 1)
                ->get();
                // dd($dosen1);

        $dosen2 = Dosen::join('bimbingan', 'bimbingan.dosen_id', '=', 'dosens.id')
                ->where('bimbingan.mahasiswa_id', '=', $id)
                ->where('bimbingan.level_pembimbing', '=', 2)
                ->get();

        return view('admin.detailDataMahasiswa', [
            'halaman' => 'dataMahasiswa',
            'mahasiswa' => Mahasiswa::find($id),
            'dosen1' => $dosen1,
            'dosen2' => $dosen2,
        ]);
    }

    public function editDataMahasiswa($id)
    {
        $periode = Mahasiswa::join('periode', 'periode.mahasiswa_id', '=', 'mahasiswas.id')
                ->where('periode.mahasiswa_id', '=', $id)
                ->select('periode.id', 'periode.semester', 'periode.semester', 'periode.tanggalMulai')
                ->get();

        return view('admin.editDataMahasiswa', [
            'halaman' => 'dataMahasiswa',
            'mahasiswa' => Mahasiswa::find($id),
            'periode' => $periode,
        ]);
    }

    public function updateDataMahasiswa(Request $request, $id)
    {
    $request->validate([
        'nama' => 'required|min:5',
        'nim' => 'required|min:8',
        'judul' => 'required|min:15',
        'angkatan' => 'required|between:4,4',
        'semester' => 'required',
        'email' => 'required|email:rfc,dns',
        'noHp' => 'required',
        'jenisKelamin' => 'required',
        'jumlah_sks' => 'required|between:1,3',
        'ipk' => 'required',
    ], [
        'nama' => [
            'required' => 'Nama belum terisi.',
            'min' => 'Isi dengan nama lengkap.',
        ],
        'nim' => [
            'required' => 'NIM belum terisi.',
            'min' => 'NIM minimal 8 karakter.',
        ],
        'judul' => [
            'required' => 'Judul Skripsi belum terisi.',
            'min' => 'Judul Skripsi minimal 15 karakter.',
        ],
        'angkatan' => [
            'required' => 'Angkatan belum terisi',
            'between' => 'Isi Angkatan dengan benar.',
        ],
        'semester' => [
            'required' => 'Semester belum di pilih.',
        ],
        'email' => [
            'required' => 'Email belum terisi.',
            'email' => 'Email tidak dapat divalidasi !',
        ],
        'noHp' => [
            'required' => 'No Handphone belum terisi.',
        ],
        'jenisKelamin' => [
            'required' => 'Jenis Kelamin belum di pilih.',
        ],
        'jumlah_sks' => [
            'required' => 'Jumlah SKS belum terisi.',
            'between' => 'Isi Jumlah SKS dengan benar.',
        ],
        'ipk' => [
            'required' => 'IPK belumi terisi.',
        ],

    ]);

    $mahasiswa = Mahasiswa::findOrFail($id);

    $mahasiswa->nim = $request->nim;
    $mahasiswa->nama = $request->nama;
    $mahasiswa->judul = $request->judul;
    $mahasiswa->angkatan = $request->angkatan;
    $mahasiswa->email = $request->email;
    $mahasiswa->noHp = $request->noHp;
    $mahasiswa->jenisKelamin = $request->jenisKelamin;
    $mahasiswa->jumlah_sks = $request->jumlah_sks;
    $mahasiswa->ipk = $request->ipk;

    $mahasiswa->save();

    $periode_id = $request->periode_id;

    $periode = Periode::findOrFail($periode_id);

    $periode->semester = $request->semester;

    $periode->save();


    sweetalert()
        ->timerProgressBar(false)
        ->timer(3000)
        ->showConfirmButton(
            $showConfirmButton = true,
            $confirmButtonText = 'Kembali',
            $confirmButtonColor = "#1A73E8")
        ->addSuccess('Data Mahasiswa berhasil diubah.');

    return redirect()->route('admin.dataMahasiswa');

    }

    public function hapusDataMahasiswa($id)
    {
        $mahasiswa = Mahasiswa::findOrfail($id);

        $mahasiswa->delete();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Mahasiswa Berhasil di hapus', 'Hapus');

        return redirect()->route('admin.dataMahasiswa');
    }


    //--- Data Dosen ---//
    public function dataDosen(Request $request)
    {
        $tahunAjaranAktif = TahunAjaran::where('status', '=', 'Aktif')
                ->select('tanggalMulai','tanggalSelesai')
                ->first();
        
        $pagination = 7;

        $dosen = Dosen::leftJoin('milestones', 'dosens.id', '=', 'milestones.dosen_id')
                ->leftJoin('bimbingan', 'dosens.id', '=', 'bimbingan.dosen_id')
                // ->whereBetween('milestones.tanggalBerakhir', [$tahunAjaranAktif->tanggalMulai, $tahunAjaranAktif->tanggalSelesai])
                ->groupBy('dosens.id', 'dosens.nidn', 'dosens.nama', 'dosens.noHp')
                ->select('dosens.id', 'dosens.nidn', 'dosens.nama', 'dosens.noHp',
                DB::raw('COUNT(DISTINCT milestones.id) as jumlah_milestone'),
                DB::raw('COUNT(DISTINCT bimbingan.mahasiswa_id) as jumlah_mahasiswa'))
                ->paginate($pagination);

        return view('admin.dataDosenAdmin', [
            'halaman' => 'dataDosen',
            'dosen' => $dosen,
        ])->with('no', ($request->input('page', 1) - 1) * $pagination);
    }

    public function tambahDataDosen()
    {
        return view('admin.tambahDataDosen', [
            'halaman' => 'dataDosen',
        ]);
    }

    public function saveDataDosen(Request $request)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'nidn' => 'required|min:8',
            'email' => 'required|email:rfc,dns',
            'password' => 'required|min:5',
            'noHp' => 'required',
            'jenisKelamin' => 'required',
            ], [
                'nama' => [
                    'required' => 'Nama belum terisi.',
                    'min' => 'Isi dengan nama lengkap.',
                ],
                'nidn' => [
                    'required' => 'NIDN belum terisi.',
                    'min' => 'NIM minimal 8 karakter.',
                ],
                'email' => [
                    'required' => 'Email belum terisi.',
                    'email' => 'Email tidak dapat divalidasi !',
                ],
                'password' => [
                    'required' => 'Password belum terisi.',
                    'min' => 'Password minimal 5 karakter.',
                ],
                'noHp' => [
                    'required' => 'No Handphone belum terisi.',
                ],
                'jenisKelamin' => [
                    'required' => 'Jenis Kelamin belum di pilih.',
                ],
        ]);
        

        $dosen = new Dosen;

        $dosen->nama = $request->nama;
        $dosen->nidn = $request->nidn;
        $dosen->email = $request->email;
        $dosen->password = Hash::make($request->password);
        $dosen->noHp = $request->noHp;
        $dosen->jenisKelamin = $request->jenisKelamin;

        $dosen->save();

        sweetalert()
            ->timerProgressBar(false)
            ->timer(3000)
            ->showConfirmButton(
                $showConfirmButton = true,
                $confirmButtonText = 'Kembali',
                $confirmButtonColor = "#1A73E8")
            ->addSuccess('Data Dosen berhasil ditambahkan.');

        return redirect()->route('admin.dataDosen');
    }

    public function detailDataDosen($id)
    {
        // dd($mahasiswa);

        return view('admin.detailDataDosen', [
            'halaman' => 'dataDosen',
            'dosen' => Dosen::find($id),
        ]);
    }

    public function editDataDosen($id)
    {

        return view('admin.editDataDosen', [
            'halaman' => 'dataDosen',
            'dosen' => Dosen::find($id),
        ]);
    }

    public function updateDataDosen(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|min:5',
            'nidn' => 'required|min:8',
            'email' => 'required|email:rfc,dns',
            'noHp' => 'required',
            'jenisKelamin' => 'required',
        ], [
            'nama' => [
                'required' => 'Nama belum terisi.',
                'min' => 'Isi dengan nama lengkap.',
            ],
            'nidn' => [
                'required' => 'NIDN belum terisi.',
                'min' => 'NIM minimal 8 karakter.',
            ],
            'email' => [
                'required' => 'Email belum terisi.',
                'email' => 'Email tidak dapat divalidasi !',
            ],
            'noHp' => [
                'required' => 'No Handphone belum terisi.',
            ],
            'jenisKelamin' => [
                'required' => 'Jenis Kelamin belum di pilih.',
            ],
        ]);

        $dosen = Dosen::findOrFail($id);

        $dosen->nama = $request->nama;
        $dosen->nidn = $request->nidn;
        $dosen->email = $request->email;
        $dosen->noHp = $request->noHp;
        $dosen->jenisKelamin = $request->jenisKelamin;

        $dosen->save();

        sweetalert()
            ->timerProgressBar(false)
            ->timer(3000)
            ->showConfirmButton(
                $showConfirmButton = true,
                $confirmButtonText = 'Kembali',
                $confirmButtonColor = "#1A73E8")
            ->addSuccess('Data Dosen berhasil diubah.');

        return redirect()->route('admin.dataDosen');

    }

    public function hapusDataDosen($id)
    {
        $dosen = Dosen::findOrfail($id);

        $dosen->milestone()->delete();
        $dosen->delete();

        toastr()
            ->progressBar(false)
            ->positionClass('toast-top-right')
            ->timeOut(3000)
            ->addSuccess('Data Dosen Berhasil di hapus', 'Hapus');

        return redirect()->route('admin.dataDosen');
    }
}
