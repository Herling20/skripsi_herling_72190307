{{-- Konfirmasi Bimbingan --}}
<div class="modal fade" id="detailBimbingan{{ $riwayat->id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Detail Bimbingan
                </h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="konfirmasiBimbinganForm"
                    class="konfirmasiBimbinganForm">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Milestone</label>
                            <textarea type="text" name="namaMilestone" id="namaMilestone" class="text-sm h-auto text-justify" disabled>{{ $riwayat->namaMilestone }}</textarea>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal Bimbingan</label>
                            <input type="text" name="tanggalBimbingan" id="tanggalBimbingan"
                                value="{{ Carbon\Carbon::parse($riwayat->tanggalBimbingan)->translatedFormat('l\, d M Y') }}" class="text-sm" disabled>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Catatan Bimbingan</label>
                            <textarea type="text" name="tanggalBimbingan" id="tanggalBimbingan" class="text-sm h-100" disabled>{{ $riwayat->catatanBimbingan }}</textarea>
                        </div>
                    </div>
                    <div class="text-end">
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
