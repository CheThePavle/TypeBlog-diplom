$(function() {
    if (window?.XMLHttpRequest) {
        let start = 0;
        let getUrlParams = window?.location?.search?.replace( '?', '') + '&start=';

        let nextHTML = $('#nextPosts');
        let showmoreHTML = $('#showmore-triger');
        let postsHTML = $('.posts');
        let loadPost = true;

        let created_at = document.querySelectorAll('.created_at');
        created_at.forEach((el) => {
            el.innerHTML = new Date(el.innerHTML + ' UTC').toLocaleString();
        })

        $(".reset_btn").click(function () {
            window.location.href = '/';
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
                url: '/post/search',
                data: getUrlParams  + start,
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
                                    <div class="date">${new Date(el?.created_at + ' UTC').toLocaleString()}</div>
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
                error: function (d) {
                    // console.log(d)
                    msg.html('<div class="alert alert-danger">Что-то пошло не так!</div>')
                }
            });
        }
        getPosts(start);
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
