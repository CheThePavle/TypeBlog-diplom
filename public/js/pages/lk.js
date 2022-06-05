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
                    <div>
                        <input maxlength="100" name="changeEmail" type="text" value="${valEmail}">
                    </div>
                    <div>
                        <textarea maxlength="1000" name="changeAbout">${valAbout}</textarea>
                    </div>
                    <div>
                        <button type="submit" class="btn hoverBtn" id="saveProfile"><span>Сохранить</span></button>
                    </div>
                    <div>
                        <button type="button" class="btn hoverBtn closed_save_profile"><span>Отмена</span></button>
                    </div>
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
                <p><i class="fa fa-envelope" aria-hidden="true"></i> <span class="emailField">${valEmail}</span></p>
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
                        <p><i class="fa fa-envelope" aria-hidden="true"></i> <span class="emailField">${valEmail}</span></p>
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
                    // console.log(d)
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
                    start += 4; //fixme
                    loadPost = false;
                    getPosts(start);
                }
            }
        });

        nextHTML.click(function (e) {
            start += 4; //fixme
            getPosts(start);
        });

        const getPosts = (start) => {
            let msg = $(".msg");
            return $.ajax({
                url: '/post/searchLk',
                data: getUrlParams  + start + '&lk=true',
                success: function (d) {
                    // console.log(d)
                    d = d?.result?.data;
                    if (d?.length === 0) {
                        nextHTML.remove();
                        showmoreHTML.remove();
                        msg.html('<div class="alert alert-success">Постов больше нет</div>');
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
                                <div class="post col-md-12 col-lg-6">
                                    <div>
                                        ${el?.read_post ? `
                                            <div class="imgBlock">
                                                <div class="viewPost"><i class="fas fa-eye"></i></div>
                                                <img class="imgViewPost" src="${el?.img_url}" alt="${el?.heading}">
                                            </div>
                                        ` : `
                                            <div class="imgBlock">
                                                <img src="${el?.img_url}" alt="${el?.heading}">
                                            </div>
                                        `}
                                        <div class="date">${new Date(el?.created_at + ' UTC').toLocaleString()}</div>
                                        <h3 class="titlePost">${el?.heading}</h3>
                                    </div>
                                    <div>
                                        <p>Статус: ${el?.name}</p>
                                        <div class="meta">
                                            <div><a href="/?category=${el?.id_category}">${el?.name_category}</a></div>
                                            <div><i class="fas fa-heart"></i> ${el?.likes > 0 ? '+' + el?.likes : el?.likes}</div>
                                            <div><i class="fas fa-eye"></i> ${el?.views} ${+el?.views_day == '0' || !el?.views_day ? '' : '(+' + el?.views_day + ')'}</div>
                                            <div><i class="fa fa-comments" aria-hidden="true"></i> ${el?.comments_count}</div>
                                        </div>
                                        ${strTags && `<p class="tagsPost">Теги: ${strTags}</p>`}
                                        <a href="/post/${el?.id_post}" class="btn hoverBtn readPost" target="_blank"><span>Посмотреть</span></a>
                                        ${el?.id_status == 4 || el?.id_status == 3 ? `<a href="/post/change/${el?.id_post}" class="btn hoverBtn" target="_blank"><span>Изменить</span></a>` : ''}
                                    </div>
                                </div>
                            `);
                        });
                    }
                },
                error: function (d) {
                    // console.log(d)
                    msg.html('<div class="alert alert-danger">Что-то пошло не так!</div>')
                }
            })
        }
        getPosts(start);
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
