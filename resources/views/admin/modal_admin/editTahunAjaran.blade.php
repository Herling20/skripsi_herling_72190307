<div class="modal fade" id="editTahunAjaran{{ $tAjaran->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Edit Tahun Ajaran</h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.editTahunAjaran', $tAjaran->id) }}" method="POST"
                    id="editTahunAjaranForm" class="editMilestoneForm">
                    @csrf
                    <div class="main-data-profile">
                        {{-- <div class="data-profile">
                            <label for="" class="text-dark text-start">Nama
                                Milestone</label>
                            <textarea type="text" class="text-sm h-auto text-justify text-black text-sm font-weight-bold" name="namaMilestone"
                                id="namaMilestone" placeholder="Isi Nama Milestone"></textarea>
                        </div> --}}
                        {{-- <div class="data-profile">
                            <label for="" class="text-dark text-start">Persen</label>
                            <input type="text" class="text-black text-sm font-weight-bold text-center" name="bobot"
                                id="bobot" placeholder="Isi bobot" value="">
                        </div> --}}
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggalMulai" id="tanggalMulai"
                                class="text-sm text-center form-control" min="{{ date('Y-m-d\TH:i') }}"
                                value="{{ date('Y-m-d\TH:i', strtotime($tAjaran->tanggalMulai)) }}">
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggalSelesai" id="tanggalSelesai"
                                class="text-sm text-center form-control"
                                value="{{ date('Y-m-d\TH:i', strtotime($tAjaran->tanggalSelesai)) }}">
                        </div>
                    </div>
                    <div id="errorContainer" class="text-danger"></div>
                    <div class="flex justify-content-end pe-3">
                        <button type="submit" class="btn btn-warning me-2">Ubah</button>
                        <button type="button" data-bs-dismiss="modal" aria-label="Close"
                            class="btn btn-info">Kembali</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
