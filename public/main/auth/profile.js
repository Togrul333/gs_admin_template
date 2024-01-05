$(document).ready(function () {
    $("#update_profile").on('click', function (e) {
        e.preventDefault();
        const form = new FormData();
        const url = $(this).data('url')
        const full_name = $('.full_name')
        const email = $('.email')
        const number = $('.number')
        const password = $('.password').val()
        const password_confirmation = $('.password_confirmation').val()

        if (password !== "" && password_confirmation !== "") {
            form.append('password', password)
            form.append('password_confirmation', password_confirmation)
        }
        form.append('full_name', full_name.val())
        form.append('email', email.val())
        form.append('number', number.val())

        Array.from($('input[name="image"]')[0].files).forEach(function (element) {
            form.append('image[]', element);
        })

        $('.input-error').text("");
        $.ajax({
            url,
            method: 'POST',
            data: form,
            dataType: 'JSON',
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: response.message,
                    showConfirmButton: false,
                    timer: 2000
                });
                // toastr.success('success');
            },
            error: function (response) {
                const result = response.responseJSON;
                if (typeof result !== 'undefined') {
                    if (typeof result.errors !== 'undefined') {
                        const errors = result.errors;
                        Object.keys(errors).forEach(function (key) {
                            $(`.error-${key.replaceAll('.', '-')}`).text(errors[key][0])
                        })
                    }
                }
                if (result.status !== 'undefined' && result.status === 500) {
                    swal.fire("Error!", result.data?.message_error);
                }
            }
        })
    });
});

