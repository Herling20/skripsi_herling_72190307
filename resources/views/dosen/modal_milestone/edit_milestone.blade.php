{{-- Edit Modal Milestone --}}

<div class="modal fade" id="editMilestone{{ $mlstn->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Edit Milestone</h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('editMlstn.dosen') }}" method="POST" id="editMilestoneForm"
                    class="editMilestoneForm">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile">
                            <input type="hidden" class="text-black text-sm font-weight-bold text-wrap"
                                name="milestone_id" id="milestone_id" value="{{ $mlstn->id }}">

                            <input type="hidden" class="text-black text-sm font-weight-bold text-wrap" name="dosen_id"
                                id="dosen_id" value="{{ Auth::user()->id }}">

                            <input type="hidden" class="text-black text-sm font-weight-bold text-center"
                                name="semester" id="semester" value="{{ $mlstn->semester }}">

                            <label for="" class="text-dark text-start">Nama
                                Milestone</label>
                            <textarea type="text" class="text-sm h-auto text-justify text-black text-sm font-weight-bold" name="namaMilestone"
                                id="namaMilestone" placeholder="Isi Nama Milestone">{{ $mlstn->namaMilestone }}</textarea>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Persen</label>
                            <input type="text" class="text-black text-sm font-weight-bold text-center" name="bobot"
                                id="bobot" placeholder="Isi bobot" value="{{ $mlstn->bobot }}">
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Akhir
                                Berlaku</label>
                            <input type="datetime-local" name="tanggalBerakhir" id="tanggalBerakhir"
                                class="text-sm text-center form-control" min="{{ date('Y-m-d\TH:i') }}"
                                value="{{ date('Y-m-d\TH:i', strtotime($mlstn->tanggalBerakhir)) }}">
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

