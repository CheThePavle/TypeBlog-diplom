$(function() {
    if (window?.XMLHttpRequest) {
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.btn-send').prop('disabled', disabled);
        }

        $("#login").keyup(function() {
            let th = $(this);
            let val = th.val();
            th.val(normalizeSpace(val));
        });

        $(".eyePassword").click(function () {
            let passwordHTML = $("#password");
            let passwordType = $("#password[type='password']");
            if (passwordType?.length) {
                passwordHTML.attr('type','text');
            } else {
                passwordHTML.attr('type','password');
            }
            $(this).toggleClass('fa-eye-slash fa-eye');
        })

        $("#password").keyup(function() {
            let th = $(this);
            let val = th.val();
            th.val(normalizeSpace(val));
        });

        $('#formAuth').submit(function (e) {
            e.preventDefault();
            activeBtn(true);

            let th = $(this);
            let msg = $('.msg');

            $.ajax({
                url: '/user/auth',
                method: 'POST',
                data: th.serialize(),
                success: function (d) {
                    console.log(d)
                    clearTimeout(timerId);
                    activeBtn(true);
                    msg.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function(){
                        window.location.href = '/lk';
                    }, 2000);
                },
                error: function (d) {
                    console.log(d)
                    clearTimeout(timerId);
                    activeBtn(true);
                    msg.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function(){
                        activeBtn(false);
                    }, 1000);
                }
            })

        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
