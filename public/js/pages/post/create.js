$(function() {
    if (window?.XMLHttpRequest) {
        let timerId = 0;

        const activeBtn = (disabled) => {
            $('.btn-send').prop('disabled', disabled);
        }

        $("#heading").keyup(function () {
            let val = $(this).val();
            $(this).val(normalizeSpace(val));
            let errorHeading = $(".errorHeading");

            errorHeading.html('');
            activeBtn(false);

            if (val?.length  < 6) {
                errorHeading.html('<div class="alert alert-warning noAnime">Название не может быть меньше 6 символов!</div>')
                activeBtn(true);
            }
        })

        $("#description").keyup(function () {
            let val = $(this).val();
            $(this).val(normalizeSpace(val));
            let errorDescription = $(".errorDescription");

            errorDescription.html('');
            activeBtn(false);

            if (val?.length  < 20) {
                errorDescription.html('<div class="alert alert-warning noAnime">Описание не может быть меньше 20 символов!</div>')
                activeBtn(true);
            }
        })

        let myOptionsTagging = {
            "no-comma": true,
            "case-sensitive": false,
            "no-duplicate": true,
            "forbidden-chars-text": '',
            "forbidden-chars-callback": function(el){
                clearTimeout(timerId);
                $(".errorTags").html('<div class="alert alert-warning">Такой символ запрещен - '+el+'</div>');
                timerId = setTimeout(() => {
                    $(".errorTags").html('')
                }, 3000)
            },
            "no-duplicate-text": '',
            "no-duplicate-callback": function(el){
                clearTimeout(timerId);
                $(".errorTags").html('<div class="alert alert-warning">Такой тег уже написан - '+el+'</div>');
                timerId = setTimeout(() => {
                    $(".errorTags").html('')
                }, 3000)
            },
            "edit-on-delete": false,
            "forbidden-chars": [
                "-", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")",
                "=", "_", "+", "`", "~", "\"", "№", ";", "%", ":", "?",
                "|", "{", "}", "[", "]", "\\", "\'", "<", ">", ",", ".", "/"],
            "tag-char": "#"
        };
        let tagBox = $("#tagBox");

        const validateTags = () => {
            let getLengthTags = $('#tagBox .tag').length;
            if (getLengthTags > 10) {
                clearTimeout(timerId);
                let value = $('#tagBox .tag:last input').val();
                tagBox.tagging( "remove", value);
                let errorTags = $(".errorTags");
                errorTags.html('<div class="alert alert-warning">Можно задать не более 10 тегов!</div>');
                timerId = setTimeout(() => {
                    errorTags.html('')
                }, 3000)
            }
        }

        tagBox.tagging(myOptionsTagging);
        $(".type-zone").keyup(function (e) {
            if (e.key === 'б' && this.value.length === 0) {
                this.value = 'б'
            } else if (e.key === 'Б' && this.value.length === 0) {
                this.value = 'Б'
            }

            validateTags();
        })
        $('.type-zone').on('keyup paste', function() {
            $(this).val(function(i, value) { return value.substr(0, 25); });
        });

        tagBox.append(`<button type="button" class="btn hoverBtn btnCreateTag"><span>Добавить</span></button>`);
        $('.btnCreateTag').on('click', function() {
            let typeZone = $('.type-zone');
            let value = typeZone.val();
            $('#tagBox').tagging( "add", value);
            typeZone.val('');

            validateTags();
        });

        const readURL = (input) => {
            if (input.files && input.files[0]) {
                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#show_img_prev').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#controlFile").change(function(e) {
            let fileName = $(this).val().split('/').pop().split('\\').pop();
            if (!fileName) {
                $(".show_img_prev_post").css({'display':'none'});
                $("#name_btn_img_prev").html('Выбрать');
                $("#img_uploaded").html('Выберите файл или перетащите его сюда');
            } else {
                $(".show_img_prev_post").css({'display':'block'});
                $("#name_btn_img_prev").html('Заменить');
                $("#img_uploaded").html('Выбран: ' + fileName);
                readURL(this);
            }

        });

        const editor = new EditorJS({
            i18n: {
                messages: {
                    ui: {
                        "blockTunes": {
                            "toggler": {
                                "Click to tune": "Нажмите, чтобы настроить",
                                "or drag to move": "или перетащите"
                            },
                        },
                        "inlineToolbar": {
                            "converter": {
                                "Convert to": "Конвертировать в"
                            }
                        },
                        "toolbar": {
                            "toolbox": {
                                "Add": "Добавить"
                            }
                        }
                    },
                    toolNames: {
                        "Text": "Параграф",
                        "Heading": "Заголовок",
                        "List": "Список",
                        "Warning": "Примечание",
                        "Checklist": "Чеклист",
                        "Quote": "Цитата",
                        "Code": "Код",
                        "Delimiter": "Разделитель",
                        "Raw HTML": "HTML-фрагмент",
                        "Table": "Таблица",
                        "Link": "Ссылка",
                        "Marker": "Маркер",
                        "Bold": "Полужирный",
                        "Italic": "Курсив",
                        "InlineCode": "Моноширинный",
                        "Image": "Картинка"
                    },
                    tools: {
                        "link": {
                            "Add a link": "Вставьте ссылку"
                        },
                        "stub": {
                            'The block can not be displayed correctly.': 'Блок не может быть отображен'
                        }
                    },
                    blockTunes: {
                        "delete": {
                            "Delete": "Удалить"
                        },
                        "moveUp": {
                            "Move up": "Переместить вверх"
                        },
                        "moveDown": {
                            "Move down": "Переместить вниз"
                        }
                    },
                }
            },
            autofocus: true,
            tools: {
                image: {
                    class: SimpleImage,
                    inlineToolbar: true,
                    config: {
                        placeholder: 'Вставте URL или перетащите картинку'
                    }
                },
                checklist: {
                    class: Checklist,
                    inlineToolbar: true,
                },
                textVariant: TextVariantTune,
                paragraph: {
                    class: Paragraph,
                    inlineToolbar: true,
                    tunes: ['textVariant']
                },
                underline: {
                    class: Underline,
                    shortcut: 'SHIFT+B'
                },
                list: {
                    class: NestedList,
                    inlineToolbar: true,
                },
                inlineCode: {
                    class: InlineCode,
                    shortcut: 'SHIFT+C',
                },
                quote: {
                    class: Quote,
                    inlineToolbar: true,
                    shortcut: 'SHIFT+O',
                    config: {
                        quotePlaceholder: 'Напишите цитату',
                        captionPlaceholder: 'Автор цитаты',
                    }
                },
                table: {
                    class: Table,
                    inlineToolbar: true,
                    config: {
                        rows: 2,
                        cols: 3,
                    }
                },
                delimiter: Delimiter,
                Marker: {
                    class: Marker,
                    shortcut: 'SHIFT+M',
                },
                warning: {
                    class: Warning,
                    inlineToolbar: true,
                    shortcut: 'SHIFT+W',
                    config: {
                        titlePlaceholder: 'Название',
                        messagePlaceholder: 'Сообщение',
                    }
                },
                header: {
                    class: Header,
                    shortcut: 'SHIFT+H',
                    config: {
                        levels: [2, 3, 4, 5, 6],
                        defaultLevel: 2
                    }
                }
            }
        });

        let forCreatePost = $('#forCreatePost');

        $('.btnDraft').click(() => {
            forCreatePost.append("<input type='hidden' name='draft' value='true'>");
        });

        forCreatePost.submit(function (e) {
            e.preventDefault();

            $('button').attr('disabled', true);

            let formData = new FormData(this);
            let msg = $('.msg');

            editor.save().then(savedData => {
                formData.append('body', JSON.stringify(savedData));
                formData.set('tags', $("#tagBox").tagging( "getTags" ));

                $.ajax({
                    url: '/post/create',
                    method: 'POST',
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (d) {
                        clearTimeout(timerId);
                        activeBtn(true);
                        msg.html(`<div class="alert alert-success">${d?.result?.msg}</div>`);
                        timerId = setTimeout(function(){
                            window.location.href = '/lk';
                        }, 2000);
                    },
                    error: function (d) {
                        $('button').attr('disabled', false);
                        clearTimeout(timerId);
                        activeBtn(true);
                        msg.html(`<div class="alert alert-danger">${d?.responseJSON?.result?.msg || 'Что-то пошло не так!'}</div>`);
                        timerId = setTimeout(function(){
                            activeBtn(false);
                        }, 1000);
                    }
                })
            })
        });
    } else {
        alert('Ваша версия браузера устарела, к сожалению поддержки пока нет');
    }
});
