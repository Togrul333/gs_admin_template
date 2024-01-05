$(function () {
    $('.login-btn').on('click', function (e) {
        e.preventDefault();
        const form = new FormData();
        const url = $(this).data('url')
        const email = $('.email')
        const password = $('.password')
        form.append('email', email.val())
        form.append('password', password.val())
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
                showServerSuccess(response);
                if (typeof response.data !== 'undefined') {
                    const result = response.data
                    if (typeof result.redirect !== 'undefined') {
                        window.location.href = result.redirect
                    }
                }
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
                    if (result.status !== 422) {
                        swal.fire("Error!", result.data?.message_error);
                    }
                }
            }
        })

    })
})

