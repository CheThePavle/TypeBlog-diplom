$(function() {
    if (window?.XMLHttpRequest) {
        let start = 0;
        let getUrlParams = window.location.search.replace( '?', '') + '&start=';
        let getIdUser = window?.location?.pathname?.substr(9);
        let timerId = 0;

        let nextHTML = $('#nextPosts');
        let showmoreHTML = $('#showmore-triger');
        let postsHTML = $('.posts');
        let loadPost = true;

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

        // fixme изменить потом
        document.querySelector('textarea').addEventListener('input', function (e) {
            e.target.style.height = 'auto'
            e.target.style.height = e.target.scrollHeight + 2 + "px"
        })

        const getPosts = (start) => {
            let msg = $(".msg");
            return $.ajax({
                url: '/post/searchProfile',
                data: getUrlParams  + start + '&id_user=' + getIdUser,
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
                                    <div class="date">${el?.created_at}</div>
                                    <h3>${el?.heading}</h3>
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
                error: function () {
                    msg.html('<div class="alert alert-danger">Что-то пошло не так!</div>')
                }
            })
        }
        getPosts(start);

        // Жалоба
        let modal_complaint = $(".modal_complaint");
        $(".complaint_profile_btn").click(function () {
            modal_complaint.show();
        })
        $(".closed_complaint").click(function () {
            modal_complaint.hide();
        })

        $('#formComplaint').submit(function (e) {
            e.preventDefault();

            let th = $(this);
            let notify = $('.notify');

            $.ajax({
                url: '/user/complaint',
                method: 'POST',
                data: th.serialize() + '&idUserAccused=' + getIdUser,
                success: function (d) {
                    clearTimeout(timerId);
                    modal_complaint.hide();
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

    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
