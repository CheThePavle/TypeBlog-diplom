$(function() {
    if (window?.XMLHttpRequest) {
        let complaintsHTML = $(".body_complaints");
        let notify = $(".notify");
        let timerId = 0;

        complaintsHTML.on( "click", ".more", function() {
            console.log('dad')
            let getId = $(this).data('id');
            $('.row' + getId).toggleClass('collapse');
            $(this).find('.iconMore').toggleClass('fa-plus fa-minus');
        });

        complaintsHTML.on( "click", ".blocked", function() {
            let getHTML = $(this).closest('.id_complaint');
            let id = getHTML.data('id');

            $.ajax({
                url: '/user/blockedComplaint',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    $(".row"+id).remove();
                    getHTML.remove();
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
        complaintsHTML.on( "click", ".rejected", function() {
            let getHTML = $(this).closest('.id_complaint');
            let id = getHTML.data('id');

            $.ajax({
                url: '/user/rejectedComplaint',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    $(".row"+id).remove();
                    getHTML.remove();
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
