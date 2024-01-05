$(function () {
    const form = new FormData();
    $('.contact_form_btn').on('click', function (e) {
        e.preventDefault();
        const url = $(this).data('url')
        const fullName = $('.fullName');
        const email = $('.email');
        const subject = $('.subject');

        form.append('fullName', fullName.val())
        form.append('email', email.val())
        form.append('subject', subject.val())
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
                toastr.success(`${response.message}`);
                $('#cont_form').find("input, textarea").val("");
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
                    // if (result.status !== 422) {
                    //     // toastr.error(`${response.message}`);
                    //     swal.fire("Error!", response.message);
                    // }
                }
            }
        })

    })
})
