{{-- Tambah Modal Milestone --}}

<div class="modal fade" id="tambahMilestone">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Tambah Milestone
                </h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('saveMlstn.dosen') }}" method="POST" id="tambahMilestoneForm">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile">
                            <input type="hidden" class="dosen_id text-black text-sm font-weight-bold text-wrap"
                                name="dosen_id" id="dosen_id" value="{{ Auth::user()->id }}">

                            <label for="" class="text-dark text-start">Nama
                                Milestone</label>
                            <textarea type="text"
                                class="namaMilestone text-sm h-auto text-justify text-black text-sm font-weight-bold is-invalid"
                                name="namaMilestone" id="namaMilestone" placeholder="Isi Nama Milestone"></textarea>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Persen</label>
                            <input type="text" class="bobot text-black text-sm font-weight-bold text-center"
                                name="bobot" id="bobot" placeholder="Isi bobot">
                        </div>
                        <div class="dropdown-dosen">
                            <label for="" class="text-dark text-start">Semester</label>
                            <select name="semester" id="semester" class="semester form-select text-center">
                                <option value="">--- Pilih Semester ---
                                </option>
                                <option value="Ganjil">Ganjil</option>
                                <option value="Genap">Genap</option>
                            </select>
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Akhir
                                Berlaku</label>
                            <input type="datetime-local" name="tanggalBerakhir" id="tanggalBerakhir"
                                class="tanggalBerakhir text-sm text-center form-control" min="{{ date('Y-m-d\TH:i') }}">
                        </div>
                    </div>
                    {{-- <button type="submit" class="btn btn-success me-2">Tambah</button> --}}
                    <button type="submit" class="tambah_milestone btn btn-success me-2">Tambah</button>
                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                        class="btn btn-info">Kembali</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $(document).on('submit', '#tambahMilestoneForm', function(e) {
            e.preventDefault();
            // console.log('hello');

            var dataMilestone = $(this).serializeArray();

            console.log(dataMilestone);

            var errorMessages = [];

            $.ajax({
                type: "POST",
                url: '{{ route('saveMlstn.dosen') }}',
                data: dataMilestone,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 'sukses') {
                        $('.tombol_tutup').click();
                        $('#tambahMilestoneForm')[0].reset();
                        $('.table-responsive').load(location.href + ' .table-responsive');
                        toastr["success"]('Data milestone telah ditambahkan.', 'Berhasil!')
                        toastr.options = {
                            "closeButton": false,
                            "progressBar": false,
                        };
                    }
                    // console.log(total);
                },
                error: function(errors) {
                    var error = errors.responseJSON;
                    console.log(error);

                    $.each(error.errors, function(elementId, message) {
                        appendErrorMessage('#' + elementId, message,
                            errorMessages);

                    });

                    // Function to append error messages
                    function appendErrorMessage(elementId, message, errorMessages) {
                        if ($(elementId).siblings('.error-message').length === 0) {
                            $(elementId).addClass('is-invalid');
                            $(elementId).after(
                                '<span class="text-danger text-sm pt-1 font-weight-normal error-message">' +
                                message +
                                '</span>');
                            errorMessages.push(message);
                            event.preventDefault();
                        }
                    }


                    // Event listener to remove error message when the corresponding input field is filled
                    $('#namaMilestone, #bobot, #semester, #tanggalBerakhir').on('input',
                        function() {
                            var inputId = '#' + $(this).attr('id');
                            if ($(inputId).val().trim() !== '') {
                                $(inputId).removeClass('is-invalid');
                                $(inputId).siblings('.error-message').remove();
                            }
                        });
                }
            });
        });
    });
</script>
