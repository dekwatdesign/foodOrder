function sendResetPassword() {

    let input_username = $('#input_reset_pass_email').val();

    $.ajax({
        url: './actions/action-reset-password.php',
        type: 'POST',
        data: {
            reset_pass_email: input_username,
        },
        dataType: 'JSON',
        beforeSend: function () {
            Swal.fire({
                html: ` <div class="d-flex flex-column flex-center gap-3">
                                <span class="fs-5 fw-bold">กำลังส่ง Email</span>
                                <img class="h-100px" src="./assets/media/svg/loading-dots-transparent.svg">
                            </div>`,
                buttonsStyling: false,
                showConfirmButton: false,
                allowOutsideClick: false
            })
        },
        success: function (result) {
            if (result.status === 1) {
                Swal.fire({
                    text: `เข้าสู่ระบบสำเร็จ`,
                    icon: "success",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 1000
                }).then(function () {
                    $('#modal_reset_password').modal('hide');
                });
            } else if (result.status === 0) {
                Swal.fire({
                    text: result.message,
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "ตกลง",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            }
        },
        error: function (jqXHR, exception) {
            Swal.fire({
                text: getErrorMessage(jqXHR, exception),
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "ตกลง",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            });
        },
    });
}

function resetPassword() {
    $('#input_reset_pass_email').removeClass('is-invalid');
    $('#input_reset_pass_email').val(null);
    $('#modal_reset_password').modal('show');
}

function resetCheckInvaid() {
    $('#input_username').removeClass('is-invalid');
    $('#input_password').removeClass('is-invalid');
}

function initCheckInvalid(elm_id) {
    $('#' + elm_id).on('change', function () {
        if ($(this).val() == '') {
            $(this).addClass('is-invalid');
        } else {
            $(this).removeClass('is-invalid');
        }
    });
}

$("form").submit(function (event) {
    event.preventDefault();

    resetCheckInvaid();

    let input_username = $('#input_username').val();
    let input_password = $('#input_password').val();

    let pass_arr_status = [];
    let pass_arr_message = [];

    if (input_username == '') {
        $('#input_username').addClass('is-invalid');
        initCheckInvalid('input_username');
        pass_arr_status.push(0);
        pass_arr_message.push('Username');
    }

    if (input_password == '') {
        $('#input_password').addClass('is-invalid');
        initCheckInvalid('input_password');
        pass_arr_status.push(0);
        pass_arr_message.push('Password');
    }

    if (pass_arr_status.includes(0)) {
        Swal.fire({
            text: 'กรุณาตรวจสอบ ' + pass_arr_message.join(', '),
            icon: "warning",
            buttonsStyling: false,
            confirmButtonText: "ตกลง",
            customClass: {
                confirmButton: "btn fw-bold btn-primary",
            }
        });
    } else {

        grecaptcha.ready(function () {
            grecaptcha.execute(recaptchaSiteKey, { action: 'submit' }).then(function (token) {
                loginProcess(token);
            });
        });

    }

});

function loginProcess(token) {
    $.ajax({
        url: './actions/work_auth_login.php',
        type: 'POST',
        data: {
            account_user: $('#input_username').val(),
            account_pass: $('#input_password').val(),
            account_remember: $('#cb_remember:checked').val() ? true : false,
            recaptcha_token: token,
        },
        dataType: 'JSON',
        beforeSend: function () {
            Swal.fire({
                html: ` <div class="d-flex flex-column flex-center gap-3">
                            <span class="fs-5 fw-bold">กำลังตรวจสอบข้อมูล</span>
                            <img class="h-100px" src="./assets/medias/svg/loading-dots-transparent.svg">
                        </div>`,
                buttonsStyling: false,
                showConfirmButton: false,
                allowOutsideClick: false
            })
        },
        success: function (result) {
            if (result.status === 'success') {
                Swal.fire({
                    text: `เข้าสู่ระบบสำเร็จ`,
                    icon: "success",
                    buttonsStyling: false,
                    showConfirmButton: false,
                    timer: 1000
                }).then(function () {
                    window.location = './';
                });
            } else if (result.status === 'error' || result.status === 'warning') {
                Swal.fire({
                    text: result.message,
                    icon: result.status,
                    buttonsStyling: false,
                    confirmButtonText: "ตกลง",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            } else {
                Swal.fire({
                    text: "Error Response!",
                    icon: "error",
                    buttonsStyling: false,
                    confirmButtonText: "ตกลง",
                    customClass: {
                        confirmButton: "btn fw-bold btn-primary",
                    }
                });
            }
        },
        error: function (jqXHR, exception) {
            Swal.fire({
                text: getErrorMessage(jqXHR, exception),
                icon: "error",
                buttonsStyling: false,
                confirmButtonText: "ตกลง",
                customClass: {
                    confirmButton: "btn fw-bold btn-primary",
                }
            });
        },
    });
}

function getErrorMessage(jqXHR, exception) {
    var msg = '';
    if (jqXHR.status === 0) {
        msg = 'Not connect.\n Verify Network.';
    } else if (jqXHR.status == 404) {
        msg = 'Requested page not found. [404]';
    } else if (jqXHR.status == 500) {
        msg = 'Internal Server Error [500].';
    } else if (exception === 'parsererror') {
        msg = 'Requested JSON parse failed.';
    } else if (exception === 'timeout') {
        msg = 'Time out error.';
    } else if (exception === 'abort') {
        msg = 'Ajax request aborted.';
    } else {
        msg = 'Uncaught Error.\n' + jqXHR.responseText;
    }
    return msg;
}