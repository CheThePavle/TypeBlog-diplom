$(function() {
    if (window?.XMLHttpRequest) {
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.btn-send').prop('disabled', disabled);
        }

        $("#login").keyup(function() {
            let th = $(this);
            let val = th.val();
            th.val(normalizeSpace(val))

            let errorLoginHTML = $('.errorLogin');
            errorLoginHTML.html('');

            if (val?.length < 5) {
                errorLoginHTML.html('<div class="alert alert-warning">Логин не может быть меньше 5 символов!</div>')
                activeBtn(true);
            }

            activeBtn(false);
            $.ajax({
                url: '/user/findLogin',
                method: 'POST',
                data: th.serialize(),
                // success: function (d) {
                //     console.log(d)
                // },
                error: function (d) {
                    // console.log(d)
                    activeBtn(true);
                    errorLoginHTML.html(`<div class="alert alert-warning">${d?.responseJSON?.result?.msg}</div>`);
                }
            })
        });

        $("#email").keyup(function() {
            let th = $(this);
            let val = th.val();
            th.val(normalizeSpace(val))

            let errorEmailHTML = $('.errorEmail');
            errorEmailHTML.html('');

            if (val?.length < 1) {
                errorEmailHTML.html('<div class="alert alert-warning">Заполните почту!</div>')
                activeBtn(true);
            }

            activeBtn(false);
            $.ajax({
                url: '/user/findEmail',
                method: 'POST',
                data: th.serialize(),
                error: function (d) {
                    activeBtn(true);
                    errorEmailHTML.html(`<div class="alert alert-warning">${d?.responseJSON?.result?.msg}</div>`);
                }
            })
        });

        $(".eye1").click(function () {
            let passwordHTML = $("#password");
            let passwordType = $("#password[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })
        $(".eye2").click(function () {
            let passwordHTML = $("#password2");
            let passwordType = $("#password2[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })

        let errorPasswordHTML = $(".errorPassword");
        $("#password").keyup(function () {
            let th = $(this);
            let val = th.val();

            th.val(normalizeSpace(val));

            errorPasswordHTML.html('');
            activeBtn(false);

            if (val?.length  < 6) {
                errorPasswordHTML.html('<div class="alert alert-warning">Пароль не может быть меньше 6 символов!</div>')
                activeBtn(true);
            }
            if (val?.length  > 32) {
                errorPasswordHTML.html('<div class="alert alert-warning">Пароль не может быть больше 32 символов!</div>')
                activeBtn(true);
            }
        })
        $("#password2").keyup(function () {
            let th = $(this);
            let p = $("#password").val();
            let p2 = th.val();

            th.val(normalizeSpace(p2));

            errorPasswordHTML.html('');
            activeBtn(false);

            if (p !== p2) {
                activeBtn(true);
                errorPasswordHTML.html('<div class="alert alert-warning">Пароли не совпадают</div>')
            }
        })

        // fixme изменить потом
        document.querySelector('textarea').addEventListener('input', function (e) {
            e.target.style.height = 'auto'
            e.target.style.height = e.target.scrollHeight + 2 + "px"
        })

        $('#formReg').submit(function (e) {
            e.preventDefault();
            activeBtn(true);

            let th = $(this);
            let msg = $('.msg');

            $.ajax({
                url: '/user/create',
                method: 'POST',
                data: th.serialize(),
                success: function (d) {
                    console.log(d)
                    msg.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    if (d?.result?.data?.redirect) {
                        setTimeout(function(){
                            window.location.href = '/login';
                        }, 2000);
                    }

                    activeBtn(false);
                    $(".stage1").hide();
                    $(".stage2").val('Подтвердить');
                    $('.verifyEmail').html(`
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="code">Код подтверждения из письма <span class="required">*</span></label>
                                <input maxlength="5" id="code" type="text" name="code" class="form-control" placeholder="Введите код *" required="required">
                            </div>
                        </div>
                    `);
                    clearTimeout(timerId);
                    setTimeout(function(){
                        msg.html('');
                    }, 4000);
                },
                error: function (d) {
                    console.log(d)
                    activeBtn(true);
                    msg.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    setTimeout(function(){
                        activeBtn(false);
                    }, 500);
                    clearTimeout(timerId);
                    timerId = setTimeout(function(){
                        msg.html('');
                    }, 3000);
                    if (d?.responseJSON?.result?.data?.redirect) {
                        setTimeout(function(){
                            activeBtn(true);
                        }, 501);
                        clearTimeout(timerId);
                        timerId = setTimeout(function(){
                            window.location.href = '/register';
                        }, 4000);
                    }
                }
            })
        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
