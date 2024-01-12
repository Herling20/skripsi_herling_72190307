

<div class="modal fade" id="selesaiBimbingan{{ $detail->detailBimbingan_id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Selesai Bimbingan</h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dosen.selesaiBimbingan', $detail->detailBimbingan_id) }}" method="POST" id="selesaiBimbinganForm"
                    class="selesaiBimbinganForm">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile">
                            <input type="hidden" name="detailBimbingan_id" id="detailBimbingan_id" value="{{ $detail->detailBimbingan_id }}">
                            <input type="hidden" name="level_pembimbing" id="level_pembimbing" value="{{ $detail->level_pembimbing }}">
                            <label for="" class="text-dark text-start">Nama
                                Mahasiswa</label>
                            <input type="text"
                                class="text-sm h-auto text-justify text-black text-sm font-weight-bold"
                                value="{{ $detail->namaMhs }}" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Milestone</label>
                            <input type="text" class="text-black text-sm font-weight-bold"
                                value="{{ $detail->namaMilestone }}" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Deskripsi Pengajuan</label>
                            <input type="text" class="text-black text-sm font-weight-bold"
                                value="{{ $detail->deskripsiPengajuan }}" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Catatan Bimbingan</label>
                            <textarea type="text" class="text-black text-sm font-weight-bold"
                                name="catatanBimbingan" id="catatanBimbingan"></textarea>
                        </div>
                        @if ($detail->level_pembimbing == 1)
                            <div class="dropdown-dosen">
                                <label for="" class="text-dark">Konfirmasi Milestone ?</label>
                                <select name="acc_dp1" id="acc_dp1" class="form-select text-center">
                                    <option value="">--- Pilih Konfirmasi Milestone ---</option>
                                    <option value="Belum">Belum</option>
                                    <option value="Setuju">Setuju
                                    </option>
                                </select>
                            </div>
                        @elseif ($detail->level_pembimbing == 2)
                            <div class="dropdown-dosen">
                                <label for="" class="text-dark">Konfirmasi Milestone ?</label>
                                <select name="acc_dp2" id="acc_dp2" class="form-select text-center">
                                    <option value="">--- Pilih Konfirmasi Milestone ---</option>
                                    <option value="Belum">Belum</option>
                                    <option value="Setuju">Setuju</option>
                                </select>
                            </div>
                        @endif
                    </div>
                    <div id="errorContainer" class="text-danger"></div>
                    <div class="flex justify-content-end pe-3">
                        <button type="submit" class="btn btn-success me-2">Simpan</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-info">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
