$(function() {
    if (window?.XMLHttpRequest) {
        let tagHTML = $(".body_tag");
        let notify = $(".notify");
        let timerId = 0;

        tagHTML.on( "click", ".changed", function() {
            let body_change_tag = $('.body_change_tag');
            body_change_tag.html('');

            let getHTML = $(this).closest('.id_tag');
            let getVal = getHTML.find('.val_tag').text();
            getHTML.find('.body_change_tag').html(`
                <form id="formTagChange">
                    <input type="text" value="${getVal}" maxlength="30" id="text_change_category" name="change_tag" class="form-control">
                    <div class="mar-top clearfix">
                        <button id="btn_send_tag_change" class="btn btn-sm btn-primary pull-right" type="submit">
                            <i class="fa fa-pencil fa-fw"></i> Изменить
                        </button>
                        <button id="btn_send_tag_change_closed" class="btn btn-sm btn-danger pull-right">
                            <i class="fa fa-pencil fa-fw"></i> Отмена
                        </button>
                    </div>
                </form>
            `);
        });

        tagHTML.on( "click", "#btn_send_tag_change_closed", function() {
            $(".body_change_tag").html("");
        });

        tagHTML.on("submit", "#formTagChange", function (e) {
            e.preventDefault();
            let th = $(this);
            let getHTML = $(th).closest('.id_tag');
            let id = getHTML.data('id');

            $.ajax({
                url: '/tag/change',
                method: 'POST',
                data: th.serialize() + '&id=' + id,
                success: function (d) {
                    clearTimeout(timerId);
                    let val = th.serializeArray();
                    getHTML.find(".val_tag").text(val[0]['value']);
                    getHTML.find(".body_change_tag").html("");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000);
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000);
                }
            })
        });

        tagHTML.on( "click", ".published", function() {
            let getHTML = $(this).closest('.id_tag');
            let id = getHTML.data('id');

            $.ajax({
                url: '/tag/published',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    let btnChange = getHTML.find(".publishedTd");
                    btnChange.html("<button type='button' class='btn btn-warning unpublished'>Скрыть</button>");
                    btnChange.toggleClass("publishedTd unpublishedTd");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000)
                }
            })
        });

        tagHTML.on( "click", ".unpublished", function() {
            let getHTML = $(this).closest('.id_tag');
            let id = getHTML.data('id');

            $.ajax({
                url: '/tag/unpublished',
                method: 'POST',
                data: {
                    id
                },
                success: function (d) {
                    clearTimeout(timerId);
                    let btnChange = getHTML.find(".unpublishedTd");
                    btnChange.html("<button type='button' class='btn btn-success published'>Опубликовать</button>");
                    btnChange.toggleClass("unpublishedTd publishedTd");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000)
                },
                error: function (d) {
                    // console.log(d)
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000)
                }
            })
        });

        tagHTML.on( "click", ".deleted", function() {
            let getHTML = $(this).closest('.id_tag');
            let id = getHTML.data('id');

            $.ajax({
                url: '/tag/delete',
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
                    }, 4000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000)
                }
            })
        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
