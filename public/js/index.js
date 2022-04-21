$(function() {
    if (window?.XMLHttpRequest) {
        $('.navbar-toggle').click(function () {
            $('#slidemenu').toggleClass("hide show");
        });

        $(".randomPost").click(function () {
            $.ajax({
                url: "/post/random",
                success: function(d) {
                    window.location.href = '/post/' + d?.result?.data;
                }
            });
        })

        let searchHTML = $('#searchPostAndUser');
        let resultHTML = $(".resultSearch");
        const getResSearch = () => {
            let searchVal = searchHTML.val();
            searchHTML.val(normalizeSpace(searchVal));

            if (searchVal === "") {
                resultHTML.html("");
            }
            else {
                $.ajax({
                    url: "/post/searchPostAndUser",
                    data: {
                        searchPostAndUser: searchVal
                    },
                    success: function(d) {
                        d = d?.result?.data;
                        resultHTML.html('');
                        if (d?.length === 0) {
                            resultHTML.append(`
                                <li>
                                    Ничего не найдено
                                </li>
                            `)
                        } else {
                            d?.map(function(el) {
                                resultHTML.append(`
                                <li>
                                    <a href="${el?.id_post ? '/post/' + el?.id_post : '/profile/' + el?.id_user}">
                                        ${el?.heading ? el?.heading + ' (пост)' : el?.login + ' (пользователь)'}
                                    </a>
                                </li>
                            `)
                            });
                        }
                    }
                });
            }
        }
        searchHTML.focus(function() {
            resultHTML.show();
            getResSearch();

            searchHTML.keyup(function() {
                getResSearch();
            });
        })
        searchHTML.blur(function() {
            setTimeout(function () {
                resultHTML.hide();
            }, 200)
        })
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
