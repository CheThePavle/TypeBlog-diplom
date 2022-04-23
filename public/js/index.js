$(function() {
    if (window?.XMLHttpRequest) {
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
