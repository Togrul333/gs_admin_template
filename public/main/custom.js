// $(document).ready(function () {
// $("form.general-ajax-submit").submit(function (e) {
//     e.preventDefault();
//     let form = $(this);
//     let button = $(this).find("button[type=submit]");
//     let formData = new FormData(this);
//     if (button.hasClass("cursor-wait")) {
//         return;
//     }

//     if (button.hasClass("ask")) {
//         swal
//             .fire({
//                 title: "Are you sure?",
//                 text: "You won't be able to revert this!",
//                 showCancelButton: true,
//                 confirmButtonColor: "#3085d6",
//                 cancelButtonColor: "#d33",
//                 confirmButtonText: "Yes, delete it!",
//             })
//             .then((result) => {
//                 if (result.value) {
//                     ajaxSubmit(form, formData, button);
//                 }
//             });
//         return;
//     }

//     ajaxSubmit(form, formData, button);
// });

// function ajaxSubmit(form, formData, button) {
//     $(".input-error").empty();
//     button.addClass("cursor-wait");
//     $.ajax({
//         url: form.attr("action"),
//         type: form.attr("method"),
//         data: formData,
//         cache: false,
//         contentType: false,
//         processData: false,
//         success: (response) => {
//             button.removeClass("cursor-wait");
//             showServerSuccess(response);
//             button.prop("disabled", true);
//             if (response.data.url.length > 0) {
//                 window.location.href = response.data.url;
//             }
//         },
//         error: function (response) {
//             button.removeClass("cursor-wait");
//             showServerError(response);
//             if (response.data.url.length > 0) {
//                 window.location.href = response.data.url;
//             }
//         },
//     });
// }

// });

// flash notification
// const Toast = Swal.mixin({
//     toast: true,
//     position: "top-end",
//     showConfirmButton: false,
//     timer: 3000,
//     timerProgressBar: true,
//     didOpen: (toast) => {
//         toast.addEventListener("mouseenter", Swal.stopTimer);
//         toast.addEventListener("mouseleave", Swal.resumeTimer);
//     },
// });

// general error logic, after ajax form submit been processed
function showServerError(response) {
    if (response.status == 422) {
        let r = response.responseJSON ?? JSON.parse(response.responseText);
        for ([field, value] of Object.entries(r.errors)) {
            let dotI = field.indexOf(".");
            if (dotI != -1) {
                field = field.slice(0, dotI);
            }
            let errorText = "";
            let errorElement = $(`.input-error[data-input=${field}]`);
            errorElement = errorElement.length
                ? errorElement
                : $(`.input-error[data-input="${field}[]"]`);
            errorElement = errorElement.length
                ? errorElement
                : $(`[name=${field}]`).closest(".form-group").find(".input-error");
            errorElement = errorElement.length
                ? errorElement
                : $(`[name="${field}[]"]`).closest(".form-group").find(".input-error");
            for (const [key, error] of Object.entries(value)) {
                errorText = errorText ? errorText + "<br>" + error : error;
            }
            errorElement.html(errorText);
        }
    } else {
        swal.fire("Error!", "Server error", "error");
    }
}

// general success logic, after ajax form submit been processed
function showServerSuccess(response) {
    console.log("response success", response);
    console.log("success", response.success);
    console.log("data", response.data);
    console.log("redirect", response.data?.redirect);
    if (response.success) {
        if (response.data?.redirect) {
            window.location.href = response.data.redirect;
        } else if (response.message) {
            // Toast.fire({
            //     icon: "success",
            //     title: response.message,
            // });
        }
    } else {
        swal.fire("Error!", response.message, "error");
    }
}



if (document.querySelector('.copy_link')) {
    document.querySelector('.copy_link').addEventListener("click", function (e) {
        e.preventDefault();
        const url = $(this).data("url");
        navigator.clipboard.writeText(url).then(
            function () {
                swal.fire({
                    text:
                        "Link  copied. \n",
                    icon: "success",
                    confirmButtonColor: "#3085d6",
                });
            },
            function () {
                console.log("Copy error");
            }
        );
    });
}

