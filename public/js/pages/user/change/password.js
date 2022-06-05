$(function() {
    if (window?.XMLHttpRequest) {
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.btn_change_password').prop('disabled', disabled);
        }

        $("#newPassword").keyup(function () {
            let oldVal = $("#oldPassword").val();
            let val = $(this).val();
            $(this).val(val.replace(/\s/g, ''));
            let errorNewPassword = $(".errorNewPassword");

            errorNewPassword.html('');
            activeBtn(false);

            if (oldVal === val) {
                errorNewPassword.html('<div class="alert alert-warning noAnime">Новый пароль не может совпадать со старым паролем!</div>')
                activeBtn(true);
            }
            if (val?.length  < 6) {
                errorNewPassword.html('<div class="alert alert-warning noAnime">Новый пароль не может быть меньше 6 символов!</div>')
                activeBtn(true);
            }
        })

        $("#newPassword2").keyup(function () {
            let val = $("#newPassword").val();
            let val2 = $(this).val();
            $(this).val(val2.replace(/\s/g, ''));
            let errorNewPassword2 = $(".errorNewPassword2");

            errorNewPassword2.html('');
            activeBtn(false);

            if (val !== val2) {
                errorNewPassword2.html('<div class="alert alert-warning noAnime">Повторный новый пароль не совпадает с новым паролем!</div>')
                activeBtn(true);
            }
        })

        $(".eye1").click(function () {
            let passwordHTML = $("#oldPassword");
            let passwordType = $("#oldPassword[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })
        $(".eye2").click(function () {
            let passwordHTML = $("#newPassword");
            let passwordType = $("#newPassword[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })
        $(".eye3").click(function () {
            let passwordHTML = $("#newPassword2");
            let passwordType = $("#newPassword2[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })

        $('#formChangePassword').submit(function (e) {
            e.preventDefault();
            activeBtn(true);

            let th = $(this);
            let msg = $('.msg');

            $.ajax({
                url: '/user/change/password',
                method: 'POST',
                data: th.serialize(),
                success: function (d) {
                    clearTimeout(timerId);
                    activeBtn(true);
                    msg.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function(){
                        msg.html('');
                        activeBtn(false);
                    }, 3000);
                },
                error: function (d) {
                    clearTimeout(timerId);
                    activeBtn(true);
                    msg.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function(){
                        msg.html('');
                        activeBtn(false);
                    }, 3000);
                }
            })
        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
