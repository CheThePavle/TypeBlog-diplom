$(function() {
    if (window?.XMLHttpRequest) {
        let usersHTML = $(".body_users");
        let notify = $(".notify");
        let timerId = 0;

        let created_at = document.querySelectorAll('.created_at');
        created_at.forEach((el) => {
            el.innerHTML = new Date(el.innerHTML + ' UTC').toLocaleString();
        })

        usersHTML.on( "change", ".change_role", function() {
            let getHTML = $(this).closest('.id_user');
            let idUser = getHTML.data('id');
            let idRole = $(this).val();

            $.ajax({
                url: '/user/changeRoleById',
                method: 'POST',
                data: {
                    idUser,
                    idRole
                },
                success: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                }
            })
        });

        usersHTML.on( "click", ".unblocked", function() {
            let getHTML = $(this).closest('.id_user');
            let id = getHTML.data('id');

            $.ajax({
                url: '/user/unblocked',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    let btnChange = getHTML.find(".unblockedTd");
                    btnChange.html("<button type='button' class='btn hoverBtn blocked'><span>Заблокировать</span></button>");
                    btnChange.toggleClass("unblockedTd blockedTd");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                }
            })
        });
        usersHTML.on( "click", ".blocked", function() {
            let getHTML = $(this).closest('.id_user');
            let id = getHTML.data('id');

            $.ajax({
                url: '/user/blocked',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    let btnChange = getHTML.find(".blockedTd");
                    btnChange.html("<button type='button' class='btn hoverBtn unblocked'><span>Разблокировать</span></button>");
                    btnChange.toggleClass("blockedTd unblockedTd");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                }
            })
        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
