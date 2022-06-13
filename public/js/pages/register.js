$(function() {
    if (window?.XMLHttpRequest) {
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.btnReg').prop('disabled', disabled);
        }

        $("#login").keyup(function() {
            let th = $(this);
            let val = th.val();
            th.val(val.replace(/[^A-z0-9]/g,''))

            let errorLoginHTML = $('.errorLogin');
            errorLoginHTML.html('');

            if (val?.length < 5) {
                errorLoginHTML.html('<div class="alert alert-warning noAnime">Логин не может быть меньше 5 символов!</div>')
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
                    errorLoginHTML.html(`<div class="alert alert-warning noAnime">${d?.responseJSON?.result?.msg}</div>`);
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
                errorEmailHTML.html('<div class="alert alert-warning noAnime">Заполните почту!</div>')
                activeBtn(true);
            }

            activeBtn(false);
            $.ajax({
                url: '/user/findEmail',
                method: 'POST',
                data: th.serialize(),
                error: function (d) {
                    activeBtn(true);
                    errorEmailHTML.html(`<div class="alert alert-warning noAnime">${d?.responseJSON?.result?.msg}</div>`);
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

            th.val(val.replace(/\s/g, ''));

            errorPasswordHTML.html('');
            activeBtn(false);

            if (val?.length  < 6) {
                errorPasswordHTML.html('<div class="alert alert-warning noAnime">Пароль не может быть меньше 6 символов!</div>')
                activeBtn(true);
            }
            if (val?.length  > 32) {
                errorPasswordHTML.html('<div class="alert alert-warning noAnime">Пароль не может быть больше 32 символов!</div>')
                activeBtn(true);
            }
        })
        $("#password2").keyup(function () {
            let th = $(this);
            let p = $("#password").val();
            let p2 = th.val();

            th.val(p2.replace(/\s/g, ''));

            errorPasswordHTML.html('');
            activeBtn(false);

            if (p !== p2) {
                activeBtn(true);
                errorPasswordHTML.html('<div class="alert alert-warning noAnime">Пароли не совпадают</div>')
            }
        })

        // fixme
        document.querySelector('textarea').addEventListener('input', function (e) {
            e.target.style.height = 'auto'
            e.target.style.height = e.target.scrollHeight + 2 + "px"
        })

        const changeCaptcha = () => {
            $('.captcha').attr('src', `/captcha?r=${Math.random()}`);
        }

        $('.captchaRefresh').click(() => {
            changeCaptcha();
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
                    // console.log(d)
                    activeBtn(true);
                    msg.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    setTimeout(function(){
                        window.location.href = '/login';
                    }, 2000);
                },
                error: function (d) {
                    // console.log(d)
                    changeCaptcha();
                    activeBtn(true);
                    msg.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    clearTimeout(timerId);
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
