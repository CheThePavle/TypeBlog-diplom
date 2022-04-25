@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Изменение поста</title>
    <meta name='description' content='Изменение поста на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пост, изменение, редактирование' />

    <script src='{{ asset('libs/EditorJS/editorjs.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/simple-image.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('libs/EditorJS/blocks/simple-image.css') }}'>
    <script src='{{ asset('libs/EditorJS/blocks/header.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/warning.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/marker.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/delimiter.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/table.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/quote.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/inline-code.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/nested-list.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/underline.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/paragraph.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/text-variant-tune.js') }}'></script>
    <script src='{{ asset('libs/EditorJS/blocks/checklist.js') }}'></script>

    <link rel='stylesheet' href='{{ asset('libs/taggingJS/tag-basic-style.css') }}'>
    <script src='{{ asset('libs/taggingJS/tagging.min.js') }}'></script>

    <link rel='stylesheet' href='{{ asset('styles/pages/post/change.css') }}'>
    <script src='{{ asset('js/pages/post/change.js') }}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Изменение поста</h1>

            <x-panel-lk />

            <form id="formChangePost" enctype="multipart/form-data">
                <h2>Превью</h2>

                <div>
                    <label>Заголовок <span class="required">*</span></label>
                    <input value="{{ $getPostInfo['heading']  }}" id="heading" maxlength="200" type="text" name="heading" placeholder="Введите заголовок поста *" required="required">
                    <div class="errorHeading"></div>
                </div>

                <div>
                    <label>Загрузить главное изображение (форматы jpg, png и gif, не более 5 Мегабайт) <span class="required">*</span></label>
                    <div class="form-group download_img_prev">
                        <button type="button" class="btn hoverBtn" id="name_btn_img_prev">Заменить</button>
                        <div id="img_uploaded">Выберите файл или перетащите его сюда</div>
                        <input type="file" name="image" class="form-control-file" id="controlFile" accept=".jpg, .jpeg, .png, .gif">
                    </div>
                    <div class="show_img_prev_post">
                        <img id="show_img_prev" src="{{ $getPostInfo['imgUrl'] }}" alt="prev_img_post" />
                    </div>
                </div>

                <div>
                    <div class="form-group">
                        <label>Краткое описание <span class="required">*</span></label>
                        <textarea maxlength="1000" rows="10" id="description" name="description" placeholder="Опишите о чем будет пост *" required="required">{{ $getPostInfo['description'] }}</textarea>
                        <div class="errorDescription"></div>
                    </div>
                </div>

                <div>
                    <label>Выберите категорию <span class="required">*</span></label>
                    @if($getCategory)
                        <select class="select" name='category'>
                            <option disabled>Изменить категорию на</option>
                            @foreach($getCategory as $cat)
                                @if($cat['id_category'] == $getPostInfo['id_category'])
                                    <option selected value='{{ $cat['id_category'] }}'>{{ $cat['name_category'] }}</option>
                                @else
                                    <option value='{{ $cat['id_category'] }}'>{{ $cat['name_category'] }}</option>
                                @endif
                            @endforeach
                        </select>
                    @endif
                </div>

                <div>
                    <label>Теги</label>
                    <div data-tags-input-name="tag" id="tagBox"></div>
                    <div class="errorTags"></div>
                </div>

                <div>
                    <h2>Содержание</h2>
                    <div id="editorjs"></div>
                </div>

                <div class="btnChangePost">
                    <button type="submit" class="btn hoverBtn btn-success btn-send"><span>Изменить</span></button>
                </div>
                <div class="msg"></div>
            </form>
        </div>
    </div>

@endsection
