$(function() {
    if (window?.XMLHttpRequest) {
        let start = 0;
        let getUrlParams = window.location.search.replace( '?', '') + '&start=';
        let timerId = 0;

        let nextHTML = $('#nextPosts');
        let showmoreHTML = $('#showmore-triger');
        let postsHTML = $('.posts');
        let loadPost = true;
        let notify = $(".notify");
        let change_info = $(".change_info");

        let change_profile_btn = $('.change_profile_btn');
        let emailField = $(".emailField");
        let valEmail = emailField.text();
        let aboutField = $(".aboutField");
        let valAbout = aboutField.text();
        change_profile_btn.click(function () {
            let change_info = $(".change_info");
            change_info.html(`
                <form id="formChangeProfile">
                    <input maxlength="100" class="form-control" name="changeEmail" type="text" value="${valEmail}">
                    <textarea maxlength="1000" class="form-control" name="changeAbout">${valAbout}</textarea>
                    <input type="button" class="btn btn-danger closed_save_profile" value="Отмена">
                    <input type="submit" class="btn btn-success" id="saveProfile" value="Сохранить">
                </form>
            `);

            change_profile_btn.toggleClass('btn-primary btn-success');
            change_profile_btn.toggleClass('change_profile_btn save_profile_btn');
            change_profile_btn.hide();
        });

        change_info.on( "click", ".closed_save_profile", function() {
            change_profile_btn.toggleClass('btn-success btn-primary');
            change_profile_btn.toggleClass('save_profile_btn change_profile_btn');
            change_profile_btn.show();

            change_info.html("");
            change_info.html(`
                <p class="emailField">${valEmail}</p>
                <p class="aboutField">${valAbout}</p>
            `);
        });

        change_info.on("submit", "#formChangeProfile", function (e) {
            e.preventDefault();
            let th = $(this);

            $.ajax({
                url: '/user/changeEmailAndAbout',
                method: 'POST',
                data: th.serialize(),
                success: function (d) {
                    clearTimeout(timerId);
                    change_profile_btn.toggleClass('btn-success btn-primary');
                    change_profile_btn.show();
                    valEmail = d?.result?.data?.email;
                    valAbout = d?.result?.data?.about;
                    change_info.html(`
                        <p class="emailField">${valEmail}</p>
                        <p class="aboutField">${valAbout}</p>
                    `);
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

        const readURL = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('.ava_img').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        let uploadimage = $("#uploadimage");
        uploadimage.change(function () {
            $('#btn_uploadimage').trigger('click');
        });

        // смена аватарки
        $('#formAvatar').submit(function (e) {
            e.preventDefault();

            let ava_img = $('.ava_img');
            let oldSrc = ava_img.attr('src');
            ava_img.removeClass('ava_img');
            ava_img.addClass('loader');
            ava_img.attr('src', '/public/imgs/loader.gif');

            let formData = new FormData(this);

            $.ajax({
                url: '/user/setAvatar',
                method: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                success: function (d) {
                    console.log(d)
                    clearTimeout(timerId);
                    ava_img.addClass('ava_img');
                    ava_img.removeClass('loader');
                    ava_img.attr('src', oldSrc);
                    readURL(uploadimage[0]);
                    notify.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                },
                error: function (d) {
                    clearTimeout(timerId);
                    ava_img.addClass('ava_img');
                    ava_img.removeClass('loader');
                    ava_img.attr('src', oldSrc);
                    notify.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg}</div>`);
                    timerId = setTimeout(function () {
                        notify.html(``);
                    }, 3000)
                }
            })
        });

        let window_scrolled;
        $(window).scroll(function() {
            window_scrolled = ($(document).height()/100)*90;
            if($(window).scrollTop() + $(window).height() >= window_scrolled) {
                if (loadPost) {
                    start += 3; //fixme
                    loadPost = false;
                    getPosts(start);
                }
            }
        });

        nextHTML.click(function (e) {
            start += 3; //fixme
            getPosts(start);
        });

        const getPosts = (start) => {
            let msg = $(".msg");
            return $.ajax({
                url: '/post/searchLk',
                data: getUrlParams  + start + '&lk=true',
                success: function (d) {
                    d = d?.result?.data;
                    if (d?.length === 0) {
                        nextHTML.remove();
                        showmoreHTML.remove();
                        msg.html('<div class="alert alert-danger">Постов больше нет</div>');
                        loadPost = false;
                    } else {
                        loadPost = true;
                        d?.map(function(el) {
                            let strTags = '';
                            el?.tags?.map(function(item) {
                                strTags += `<a href="/?category=1&tag[]=${item?.id_tag}">${item?.name_tag + ', '}</a>`;
                            });
                            if (strTags) {
                                strTags = strTags?.slice(0, strTags?.length - 6) + '</a>';
                            }
                            postsHTML.append(`
                                <div class="post">
                                    <img src="${el?.img_url}" alt="${el?.heading}">
                                    <div class="date">${el?.created_at}</div>
                                    <h3>${el?.heading} ${el?.read_post ? '<span class="readPost">(просмотрен)</span>' : ''}</h3>
                                    <p>Статус: ${el?.name}</p>
                                    <div class="meta">
                                        <div><i class="fa-solid fa-user"></i> <a href="/profile/${el?.id_creator}">${el?.user_login}</a></div>
                                        <div><a href="/?category=${el?.id_category}">${el?.name_category}</a></div>
                                        <div><i class="fas fa-heart"></i> ${el?.likes > 0 ? '+' + el?.likes : el?.likes}</div>
                                        <div><i class="fas fa-eye"></i> ${el?.views} ${+el?.views_day == '0' || !el?.views_day ? '' : '(+' + el?.views_day + ')'}</div>
                                        <div><i class="fa fa-comments" aria-hidden="true"></i> ${el?.comments_count}</div>
                                    </div>
                                    <p>${el?.description}</p>
                                    ${strTags && `<p>Теги: ${strTags}</p>`}
                                    <a href="/post/${el?.id_post}" class="btn hoverBtn" target="_blank"><span>Читать дальше</span></a>
                                </div>
                            `);
                        });
                    }
                },
                error: function (d) {
                    console.log(d)
                    msg.html('<div class="alert alert-danger">Что-то пошло не так!</div>')
                }
            })
        }
        getPosts(start);
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
