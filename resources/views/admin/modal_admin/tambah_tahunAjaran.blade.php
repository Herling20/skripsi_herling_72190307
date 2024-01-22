<div class="modal fade" id="tambahTahunAjaran">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark">Tambah Tahun Ajaran
                </h5>
                <button type="button" class="tombol_tutup btn btn-link text-dark col-1 btn-lg" data-bs-dismiss="modal"
                    aria-label="Close">
                    <i class="material-icons bi bi-x"></i>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="tambahTahunAjaranForm">
                    @csrf
                    <div class="main-data-profile">
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal Mulai</label>
                            <input type="datetime-local" name="tanggalMulai" id="tanggalMulai"
                                class="tanggalMulai text-sm text-center form-control" min="{{ date('Y-m-d\TH:i') }}">
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tanggal Selesai</label>
                            <input type="datetime-local" name="tanggalSelesai" id="tanggalSelesai"
                                class="tanggalSelesai text-sm text-center form-control">
                        </div>
                        <div class="data-profile">
                            <label for="" class="text-dark text-start">Tahun Ajaran</label>
                            <input type="text" class="tahun text-black text-sm font-weight-bold text-center"
                                name="tahun" id="tahun" value="">
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
    // Mendapatkan tanggal saat ini
    var currentDate = new Date();

    // Menambahkan 5 bulan ke tanggal saat ini
    currentDate.setMonth(currentDate.getMonth() + 5);

    // Format tanggal ke dalam format yang diterima oleh input datetime-local
    var formattedDate = currentDate.toISOString().slice(0, 16);

    // Menetapkan nilai minimum pada elemen input
    document.getElementById("tanggalSelesai").min = formattedDate;
</script>

<script>
    $('document').ready(function() {
        $('#tanggalMulai').on('change', function() {
            var tanggalMulai = new Date($('#tanggalMulai').val());

            // Make sure tanggalMulai is a valid date
            if (isNaN(tanggalMulai)) {
                console.error('Invalid start date');
                return;
            }

            // Calculate tanggalSelesai by adding 5 months to tanggalMulai
            var tanggalSelesai = new Date(tanggalMulai);
            tanggalSelesai.setMonth(tanggalMulai.getMonth() + 4);
            tanggalSelesai.setHours(tanggalMulai.getHours());
            tanggalSelesai.setMinutes(tanggalMulai.getMinutes());
            console.log(tanggalMulai);
            console.log(tanggalSelesai);

            // Format tanggalSelesai as YYYY-MM-DDTHH:mm in local time
            var formattedTanggalSelesai = tanggalSelesai.toLocaleString('sv').replace(',', '');
            console.log(formattedTanggalSelesai);

            // Set the value of tanggalSelesai input field
            $('#tanggalSelesai').val(formattedTanggalSelesai);

            var tahunMulai = tanggalMulai.getFullYear();

            // var tahunMulai = date('Y')
            console.log(tahunMulai);
            $('#tahun').val(tahunMulai);

            var selectedSemester = '';

            if (tanggalMulai.getMonth() <= 5) {
                $('#semester').val('Genap')
            } else {
                $('#semester').val('Ganjil')
            }
        });
    });
</script>

<script>
    $(document).ready(function() {
        $(document).on('submit', '#tambahTahunAjaranForm', function(e) {
            e.preventDefault();
            // console.log('hello');

            var dataTahunAjaran = $(this).serializeArray();

            console.log(dataTahunAjaran);

            var errorMessages = [];

            $.ajax({
                type: "POST",
                url: '{{ route('admin.saveTahunAjaran') }}',
                data: dataTahunAjaran,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 'sukses') {
                        // $('#tambahMilestone').modal('hide');
                        $('.tombol_tutup').click();
                        $('#tambahTahunAjaranForm')[0].reset();
                        $('.table-responsive').load(location.href + ' .table-responsive');
                        toastr["success"]('Data Tahun Ajaran telah ditambahkan.',
                            'Berhasil!')
                        toastr.options = {
                            "closeButton": false,
                            "progressBar": false,
                        };
                    }
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
                    $('#semester, #tanggalMulai, #tanggalSelesai').on('input',
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
