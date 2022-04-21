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

    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active">
                <form id="forCreatePost" enctype="multipart/form-data">
                    <div class="controls">
                        <div class="row">
                            <div class="col-md-12">
                                <h2>Превью</h2>
                                <div class="form-group">
                                    <label>Заголовок <span class="required">*</span></label>
                                    <input id="heading" maxlength="200" type="text" name="heading" class="form-control" placeholder="Введите заголовок поста *" required="required">
                                    <div class="errorHeading"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Загрузить главное изображение (форматы jpg, png и gif, не более 5 Мегабайт) <span class="required">*</span></label>
                                <div class="form-group download_img_prev">
                                    <button type="button" id="name_btn_img_prev">Выбрать</button>
                                    <div id="img_uploaded">Выберите файл или перетащите его сюда</div>
                                    <input type="file" name="image" class="form-control-file" id="controlFile" accept=".jpg, .jpeg, .png, .gif">
                                </div>
                                <div class="show_img_prev_post">
                                    <img id="show_img_prev" src="#" alt="prev_img_post" />
                                    <br><br>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>Краткое описание <span class="required">*</span></label>
                                    <textarea maxlength="1000" rows="10" id="description" name="description" class="form-control" placeholder="Опишите о чем будет пост *" required="required"></textarea>
                                    <div class="errorDescription"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <label>Выберите категорию <span class="required">*</span></label>
                                <br>
                                @if($getCategory)
                                    <select name='category'>
                                    @foreach($getCategory as $cat)
                                        <option value='{{ $cat['id_category'] }}'>{{ $cat['name_category'] }}</option>
                                    @endforeach
                                    </select>
                                @endif
                            </div>

                            <div class="col-md-12">
                                <br>
                                <label>Теги</label>
                                <br>
                                <div data-tags-input-name="tag" id="tagBox" class="form-control"></div>
                                <div class="errorTags"></div>
                            </div>

                            <div class="col-md-12">
                                <h2>Содержание</h2>
                                <div id="editorjs"></div>
                            </div>

                            <div class="col-md-12">
                                <input type="submit" class="btn btn-success btn-send" value="Создать">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="msg"></div>
                </form>
            </div>
        </div>
    </div>

@endsection
