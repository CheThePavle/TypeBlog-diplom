$(function() {
    if (window?.XMLHttpRequest) {
        let categoryHTML = $(".body_category");
        let notify = $(".notify");
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.add').prop('disabled', disabled);
        }

        categoryHTML.on( "click", ".changed", function() {
            let body_change_category = $('.body_change_category');
            body_change_category.html('');

            let getHTML = $(this).closest('.id_category');
            let getVal = getHTML.find('.val_category').text();
            getHTML.find('.body_change_category').html(`
                <form id="formCategoryChange">
                    <input type="text" value="${getVal}" maxlength="30" id="text_change_category" name="change_category" class="form-control">
                    <div class="mar-top clearfix">
                        <button id="btn_send_category_change" class="btn btn-sm hoverBtn" type="submit">
                            <span><i class="fa fa-pencil fa-fw"></i> Изменить</span>
                        </button>
                        <button id="btn_send_category_change_closed" class="btn btn-sm hoverBtn">
                            <span>Отмена</span>
                        </button>
                    </div>
                </form>
            `);
        });

        categoryHTML.on( "click", "#btn_send_category_change_closed", function() {
            $(".body_change_category").html("");
        });

        categoryHTML.on("submit", "#formCategoryChange", function (e) {
            e.preventDefault();
            let th = $(this);
            let getHTML = $(th).closest('.id_category');
            let id = getHTML.data('id');

            $.ajax({
                url: '/category/change',
                method: 'POST',
                data: th.serialize() + '&id=' + id,
                success: function (d) {
                    clearTimeout(timerId);
                    let val = th.serializeArray();
                    getHTML.find(".val_category").text(val[0]['value']);
                    getHTML.find(".body_change_category").html("");
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000);
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000);
                }
            })
        });


        $('#formCreateCategory').submit(function (e) {
            e.preventDefault();
            let th = $(this);

            $.ajax({
                url: '/category/create',
                method: 'POST',
                data: th.serialize(),
                success: function (d) {
                    activeBtn(true);
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        // добавить динамический вывод в таблицу без перезагрузки
                        window.location.href = '/category/list';
                        notify.html(``);
                    }, 3000);
                },
                error: function (d) {
                    clearTimeout(timerId);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 4000);
                }
            })
        });


        categoryHTML.on( "click", ".deleted", function() {
            let getHTML = $(this).closest('.id_category');
            let id = getHTML.data('id');

            $.ajax({
                url: '/category/delete',
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
