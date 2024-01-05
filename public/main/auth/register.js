const loansItem = document.querySelectorAll('.loans-item');
const registerBtn = document.querySelector('.register_submit');

let selectSubscribeMonthValue = null;

loansItem.forEach(value => value.addEventListener('click', (e) => {
    if (e.target.parentElement.className == 'loans') {

        [...e.target.parentElement.children].forEach(child => {
            if (child.className.includes('active_loans')) {
                selectSubscribeMonthValue = child.getAttribute('data-package')
            }
        })
    } else {
        selectSubscribeMonthValue = e.target.parentElement.getAttribute('data-package')

    }

}));

document.addEventListener('click', (e) => {

    
    if (e.target.parentElement.className.includes('loans') == false && e.target.className.includes('loans-item') == false) {
        selectSubscribeMonthValue = null;
        loansItem.forEach(loanItem => loanItem.classList.remove('active_loans'))
        loansItem.forEach(loanItem => loanItem.querySelector('span').classList.remove('active_loans'))
    }
})

$(document).ready(function () {
    $("#register_bnt").on('click', function (e) {
        e.preventDefault();
        const form = new FormData();
        const url = $(this).data('url')
        const full_name = $('.full_name')
        const email = $('.email')
        const number = $('.number')
        const password = $('.password')
        const password_confirmation = $('.password_confirmation')

        form.append('full_name', full_name.val())
        form.append('email', email.val())
        form.append('number', number.val())
        form.append('password', password.val())
        form.append('password_confirmation', password_confirmation.val())

        // $('.package_i').each(function () {
        //     if ($(this).hasClass('active_loans')) {
        //         var price = $(this).data('package');
        //         console.log(price)
        //         form.append('package_id', price);
        //     } else {
        //         form.append('package_id', null);
        //     }
        // });

        form.append('package_id', selectSubscribeMonthValue);

        $('.input-error').text("");
        $.ajax({
            url,
            method: 'POST',
            data: form,
            dataType: 'JSON',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                // Swal.fire({
                //     icon: 'success',
                //     title: 'Success!',
                //     text: 'you have successfully registered',
                //     showConfirmButton: false,
                //     timer: 2000
                // });
                $('.register_page').css("display", 'none')
                $('.help_page').css("display", '')
                // toastr.success('success');
                setTimeout(function () {
                    showServerSuccess(response);
                }, 2000);
            },
            error: function (response) {
                const result = response.responseJSON;
                if (typeof result !== 'undefined') {
                    if (typeof result.errors !== 'undefined') {
                        const errors = result.errors;
                        Object.keys(errors).forEach(function (key) {
                            // toastr.error(`${response.message}`);
                            // toastr.error(`${errors[key][0]}`);
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

