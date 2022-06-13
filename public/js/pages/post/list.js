$(function() {
    if (window?.XMLHttpRequest) {
        let postsHTML = $(".body_posts");
        let notify = $(".notify");
        let timerId = 0;

        let created_at = document.querySelectorAll('.created_at');
        created_at.forEach((el) => {
            el.innerHTML = new Date(el.innerHTML + ' UTC').toLocaleString();
        })

        postsHTML.on( "click", ".published", function() {
            let getHTML = $(this).closest('.id_post');
            let id = getHTML.data('id');

            $.ajax({
                url: '/post/published',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
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
        postsHTML.on( "click", ".rejected", function() {
            let getHTML = $(this).closest('.id_post');
            let id = getHTML.data('id');

            $.ajax({
                url: '/post/rejected',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
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
