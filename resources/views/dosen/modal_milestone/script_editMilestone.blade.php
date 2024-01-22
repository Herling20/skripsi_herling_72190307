<script>
    $(document).ready(function() {
        $(document).on('submit', '.editMilestoneForm', function(e) {
            e.preventDefault();

            var form = $(this);
            var dataMilestone = form.serializeArray();
            var modalId = form.closest('.modal').attr('id'); // Get the ID of the closest modal

            console.log(dataMilestone);

            var errorMessages = [];

            $.ajax({
                type: "POST",
                url: '{{ route('editMlstn.dosen') }}',
                data: dataMilestone,
                dataType: "JSON",
                success: function(response) {
                    // console.log(response);
                    if (response.status == 'sukses') {
                        $('.tombol_tutup').click();
                        $('#editMilestoneForm')[0].reset();
                        $('.table-responsive').load(location.href + ' .table-responsive');
                        toastr["success"]('Data milestone Berhasil di ubah.', 'Berhasil!')
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
                        appendErrorMessage('#' + modalId + ' #' + elementId,
                            message, errorMessages); // Update the selector
                        // appendErrorMessage('#' + elementId, message);

                    });

                    // Function to append error messages
                    function appendErrorMessage(elementId, message, errorMessages) {
                        if ($(elementId).siblings('.error-message').length === 0) {
                            $(elementId).addClass('is-invalid');
                            $(elementId).after(
                                '<span class="text-danger text-sm pt-1 font-weight-normal error-message text-wrap">' +
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
