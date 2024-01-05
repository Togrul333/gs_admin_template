const supportCountItems = document.querySelectorAll('.support_count_item');
const payCountInput = document.querySelector('.pay_count');

let selectedSupportCountItem = null;

supportCountItems.forEach(support => support.addEventListener('click', (e) => {
    selectedSupportCountItem = Number(e.target.getAttribute('data-price'));
    payCountInput.value = ""

}));

payCountInput.addEventListener('input', (e) => {
    if (e.target.value.length > 0) {
        selectedSupportCountItem = Number(e.target.value)
        supportCountItems.forEach(support => {
            support.classList.remove('active_loans')

        })
    }
})
$(document).ready(function () {
    $(".btn_help").on('click', function (e) {
        e.preventDefault();
        const form = new FormData();
        const url = $(this).data('url')
        if (selectedSupportCountItem) {
            form.append('total_amount', selectedSupportCountItem);

        } else {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'enter or select the amount',
                showConfirmButton: false,
                timer: 2000
            });
        }

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
                window.open(response.paymentUrl)
            },
            error: function (response) {
                const result = response.responseJSON;
                if (typeof result !== 'undefined') {
                    if (typeof result.errors !== 'undefined') {
                        const errors = result.errors;
                        Object.keys(errors).forEach(function (key) {
                            // toastr.error(`${response.message}`);
                            toastr.error(`${errors[key][0]}`);
                            // $(`.error-${key.replaceAll('.', '-')}`).text(errors[key][0])
                        })
                    }
                }
                if ( result.status === 500) {
                    swal.fire("Error!", result.data?.message_error);
                }
            }
        })
    });
});

