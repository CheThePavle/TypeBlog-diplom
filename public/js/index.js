$(function() {
    if (window?.XMLHttpRequest) {
        $('#change_theme').on('click', function(){
            let th = $(this);
            th.toggleClass('dark');

            let burger = $('.navbar');
            let root = $(':root');
            if (th.hasClass('dark')) {
                root.css('--bgMenu', '#353535');
                root.css('--textMenu', '#fff');
                root.css('--hoverItemMenu', '#10ddb4');
                root.css('--oneLineMenu', '#10ddb4');
                root.css('--twoLineMenu', '#fff');
                root.css('--bgMain', '#1c1c1c');
                root.css('--bgFooter', '#000000');
                root.css('--textDate', '#242529');
                root.css('--name', '#242529');
                root.css('--bgBlock', '#10ddb4');
                root.css('--textTitle', '#fff');
                root.css('--textSelect', '#747474');
                root.css('--text', '#8c8c8c');
                root.css('--textLink', '#10ddb4');
                root.css('--bButtom', '#10ddb4');
                root.css('--hoverBgBtn', '#fff');
                root.css('--hoverBorderBtn', '#000');
                root.css('--activeBgBtn', '#979797');
                root.css('--activeBgBtnLk', '#fff');
                root.css('--textColor', '#000000');
                root.css('--colorBtn', '#000');
                root.css('--colorSpan', '#000');
                root.css('--colorTag', '#fff');
                root.css('--colorLike', '#00a300');
                root.css('--colorDislike', '#ff5959');
                root.css('--colorOdd', '#474747');

                burger.removeClass('navbar-light');
                burger.addClass('navbar-dark');

                $.ajax({
                    url: '/changeTheme',
                    method: 'POST',
                    data: {
                        dark: true
                    }
                })

                $('.logoMenu').toggleClass('logoMenuDark logoMenu');
            } else {
                root.css('--bgMenu', '#f8f8f8');
                root.css('--textMenu', '#000000');
                root.css('--hoverItemMenu', '#0d9277');
                root.css('--oneLineMenu', '#0d9277');
                root.css('--twoLineMenu', '#000000');
                root.css('--bgMain', '#ffffff');
                root.css('--bgFooter', '#d6d6d6');
                root.css('--textDate', '#eeeeee');
                root.css('--name', '#eeeeee');
                root.css('--bgBlock', '#0d9277');
                root.css('--textTitle', '#000000');
                root.css('--textSelect', '#000000');
                root.css('--text', '#000000');
                root.css('--textLink', '#0d9277');
                root.css('--bButtom', '#0d9277');
                root.css('--hoverBgBtn', '#eeeeee');
                root.css('--hoverBorderBtn', '#ffffff');
                root.css('--activeBgBtn', '#939aa1');
                root.css('--activeBgBtnLk', '#000000');
                root.css('--textColor', '#000000');
                root.css('--colorBtn', '#ffffff');
                root.css('--colorSpan', '#000000');
                root.css('--colorTag', '#fff');
                root.css('--colorLike', '#79db79');
                root.css('--colorDislike', '#ff8e8e');
                root.css('--colorOdd', '#eeeeee');

                burger.removeClass('navbar-dark');
                burger.addClass('navbar-light');

                $.ajax({
                    url: '/changeTheme',
                    method: 'POST',
                    data: {
                        dark: false
                    }
                })

                $('.logoMenuDark').toggleClass('logoMenu logoMenuDark');
            }
        });

        $('.select').each(function() {
            const _this = $(this),
                selectOption = _this.find('option'),
                selectOptionLength = selectOption.length,
                selectedOption = selectOption.filter(':selected'),
                duration = 300; // длительность анимации

            _this.hide();
            _this.wrap('<div class="select"></div>');
            $('<div>', {
                class: 'new-select',
                text: _this.children('option:disabled').text()
            }).insertAfter(_this);

            const selectHead = _this.next('.new-select');
            $('<div>', {
                class: 'new-select__list'
            }).insertAfter(selectHead);

            const selectList = selectHead.next('.new-select__list');
            for (let i = 1; i < selectOptionLength; i++) {
                $('<div>', {
                    class: 'new-select__item',
                    html: $('<span>', {
                        text: selectOption.eq(i).text()
                    })
                })
                    .attr('data-value', selectOption.eq(i).val())
                    .appendTo(selectList);
            }

            const selectItem = selectList.find('.new-select__item');
            selectList.slideUp(0);
            selectHead.on('click', function() {
                if ( !$(this).hasClass('on') ) {
                    $(this).addClass('on');
                    selectList.slideDown(duration);

                    selectItem.on('click', function() {
                        let chooseItem = $(this).data('value');

                        $('select').val(chooseItem).attr('selected', 'selected');
                        selectHead.text( $(this).find('span').text() );

                        selectList.slideUp(duration);
                        selectHead.removeClass('on');
                    });

                } else {
                    $(this).removeClass('on');
                    selectList.slideUp(duration);
                }
            });
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
