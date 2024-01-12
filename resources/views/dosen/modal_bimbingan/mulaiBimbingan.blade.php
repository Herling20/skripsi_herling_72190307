
<div class="modal fade" id="mulaiBimbingan{{ $detail->detailBimbingan_id }}">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Mulai Bimbingan
                </h5>
                <button type="button" class="btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('dosen.mulaiBimbingan', $detail->detailBimbingan_id) }}" method="POST">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile text-center">
                            <h6 class="text-dark w-100">Anda ingin memulai bimbingan ini ?</h6>
                        </div>
                        <div class="w-50">
                            <button type="submit" class="btn btn-success">Mulai</button>
                        </div>
                        <div class="w-50">
                            <button type="button" class="btn btn-info" data-bs-dismiss="modal"
                                aria-label="Close">BATAL</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
