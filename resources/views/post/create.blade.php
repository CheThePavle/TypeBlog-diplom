@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Создание поста</title>
    <meta name='description' content='Создание поста на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пост, создание, отправление, проверка' />

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

    <link rel='stylesheet' href='{{ asset('styles/pages/post/create.css') }}'>
    <script src='{{ asset('js/pages/post/create.js') }}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Создать пост</h1>

            <x-panel-lk />

            <form id="forCreatePost" enctype="multipart/form-data">
                <h2>Превью</h2>
                <div>
                    <label>Заголовок <span class="required">*</span></label>
                    <input id="heading" maxlength="200" type="text" name="heading" placeholder="Введите заголовок поста *" required="required">
                    <div class="errorHeading"></div>
                </div>

                <div>
                    <label>Загрузить главное изображение (форматы jpg, png и gif, не более 5 Мегабайт) <span class="required">*</span></label>
                    <div class="form-group download_img_prev">
                        <button type="button" class="btn hoverBtn" id="name_btn_img_prev"><span>Выбрать</span></button>
                        <div id="img_uploaded">Выберите файл или перетащите его сюда *</div>
                        <input type="file" name="image" class="form-control-file" id="controlFile" accept=".jpg, .jpeg, .png, .gif">
                    </div>
                    <div class="show_img_prev_post">
                        <img id="show_img_prev" src="#" alt="prev_img_post" />
                    </div>
                </div>

                <div>
                    <label>Краткое описание <span class="required">*</span></label>
                    <textarea maxlength="1000" rows="10" id="description" name="description" placeholder="Опишите о чем будет пост *" required="required"></textarea>
                    <div class="errorDescription"></div>
                </div>

                <div>
                    <label>Выберите категорию <span class="required">*</span></label>
                    @if($getCategory)
                        <select class="select" name='category'>
                            <option disabled>Выбрать</option>
                            @foreach($getCategory as $cat)
                                <option value='{{ $cat['id_category'] }}' {{ $loop->first ? 'selected' : '' }}>{{ $cat['name_category'] }}</option>
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

                <div class="btnPost">
                    <button type="submit" class="btn hoverBtn btnCreate"><span>Создать</span></button>
                    <button type="submit" class="btn hoverBtn btnDraft"><span>Сохранить как черновик</span></button>
                </div>

                <div class="msg"></div>
            </form>
        </div>
    </div>

@endsection
