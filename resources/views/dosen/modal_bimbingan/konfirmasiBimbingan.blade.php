{{-- Konfirmasi Bimbingan --}}
<div class="modal fade" id="konfirmasiBimbingan{{ $detail->detailBimbingan_id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Konfirmasi Bimbingan
                </h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dosen.konfirmasiBimbingan') }}" method="POST" id="konfirmasiBimbinganForm"
                    class="konfirmasiBimbinganForm">
                    @csrf
                    <div class="main-data-profile">
                        <input type="hidden" name="detailBimbingan_id" id="detailBimbingan_id"
                            value="{{ $detail->detailBimbingan_id }}">
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Nama
                                Mahasiswa</label>
                            <input type="text" name="namaMahasiswa" id="namaMahasiswa" value="{{ $detail->namaMhs }}"
                                class="text-sm" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Milestone</label>
                            <textarea type="text" name="namaMilestone" id="namaMilestone" class="text-sm h-auto text-justify" disabled>{{ $detail->namaMilestone }}</textarea>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Deskripsi
                                Pengajuan</label>
                            <input type="text" name="deskripsiPengajuan" id="deskripsiPengajuan"
                                value="{{ $detail->deskripsiPengajuan }}" class="text-sm" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal
                                Bimbingan</label>
                            <input type="datetime-local" name="tanggalBimbingan" id="tanggalBimbingan"
                                class="text-sm text-center" min="{{ date('Y-m-d\TH:i') }}" value="">

                        </div>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success" name="statusBimbingan" id="statusBimbingan"
                            value="Disetujui">Terima</button>
                        <button type="submit" class="btn btn-danger" name="statusBimbingan" id="statusBimbingan"
                            value="Ditolak">Tolak</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-info">Kembali</button>
                        <input type="hidden" name="statusBimbingan" id="statusBimbingan" disabled>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
{{-- End Konfirmasi Bimbingan --}}
