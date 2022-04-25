@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - {{ $getHeading }}</title>
    <meta name='description' content='{{ $getDescription }}'>
    <meta name='keywords' content='{{ $getTagsStr }}' />

    <meta property='og:title' content='{{ $getHeading }}' />
    <meta property='og:description' content='{{ $getDescription }}' />
    <meta property='og:image' content='{{ $imgUrl }}' />
    <meta property='og:url' content='{{ $getUrl }}' />
    <meta property='og:site_name' content='{{ env('NAME_SITE') }}' />

    <meta name='twitter:site' content='{{ env('NAME_SITE') }}' />
    <meta name='twitter:title' content='{{ $getHeading }}' />
    <meta name='twitter:description' content='{{ $getDescription }}' />

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

    <script src='https://yastatic.net/share2/share.js'></script>
    <script src='{{ asset('libs/qrcode/qrcode.min.js') }}'></script>

    <link rel='stylesheet' href='{{ asset('styles/pages/post.css') }}'>
    <script src='{{ asset('js/pages/post.js') }}'></script>

    <link rel='stylesheet' href='{{ asset('styles/components/comments.css') }}'>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">{{ $category }}</h1>
            <div class="col-lg-8 post">
                <div class="msg"></div>

                <div class="prevPost"></div>

                <h3>Содержание</h3>
                <div id="editorjs"></div>

                <div class="likesPost"></div>

                <div class="repost">
                    <h3>Поделиться в соц. сетях</h3>
                    <div class="ya-share2" data-curtain data-shape="round" data-limit="5" data-services="vkontakte,telegram,odnoklassniki,twitter,whatsapp,facebook,messenger,viber,moimir,skype,tumblr,evernote,linkedin,lj,blogger,delicious,digg,reddit,pocket,qzone,renren,sinaWeibo,surfingbird,tencentWeibo"></div>
                </div>
                <div id="qrcode"></div>

                <x-comments />
            </div>

            <div class="col-lg-4">
                <div class="sidebarItem">
                    <form>
                        <div id="block_search">
                            <input type="search" placeholder="Найти" id="searchPostAndUser" maxlength="50">
                            <ul class="resultSearch"></ul>
                        </div>
                    </form>
                </div>
                <form action="/" class="sidebarItem filterSidebar">
                    <div>
                        <h5>Сортировка</h5>
                        <select class="select" name="order">
                            <option disabled>Выбрать</option>
                            <option value="1">Сначала старые</option>
                            <option value="0" selected>Сначала новые</option>
                        </select>
                    </div>
                    <div>
                        <h5>Категория</h5>
                        <div class="category">
                            @if(count($getCategorys) > 0)
                                @foreach($getCategorys as $cat)
                                    @php
                                        $id = $cat['id_category'];
                                    @endphp
                                    <div>
                                        <input type="radio" class="btn-check" name="category" id='id{{ $id }}' value='{{ $id }}' {{ $id == $idCategory ? 'checked' : '' }}>
                                        <label class="btn btn-secondary labelCategory" for="id{{ $id }}">{{ $cat['name_category'] }} <span class="countCategory">{{ $loop->first ? $getCountDefaultCategory : $cat['count'] }}</span></label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    <div>
                        <h5>Теги</h5>
                        <div class="tags">
                            <ul class="listTags">
                                @if(count($getTag) > 0)
                                    @php
                                        foreach ($getTag as $el) {
                                            $checked = isset($el['checked']) ? 'checked' : '';
                                            $idTag = $el['id_tag'];
                                            $nameTag = $el['name_tag'];
                                            echo "<li><input name='tag[]' type='checkbox' id='idT$idTag' $checked value='$idTag'><label class='labelTag' for='idT$idTag'> $nameTag</label></li>";
                                        }
                                    @endphp
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div>
                        <button type="submit" class="btn hoverBtn btn_search">Применить</button>
                    </div>
                    <div>
                        <input type="button" class="btn bg-gray hoverBtn reset_btn" value="Сбросить">
                    </div>
                </form>
                <div class="sidebarItem">
                    <h5>Последние комментарии</h5>
                    <div>
                        @foreach($getLastComments as $comment)
                            <div class="commentItem">
                                <img src="{{ $comment['img_url'] }}" alt="{{ $comment['heading'] }}">
                                <div class="bodyCommentItem">
                                    <h6>{{ $comment['login'] }}<span> в </span><a href="{{ route('post', ['id' => $comment['id_post']]) }}">{{ $comment['heading'] }}</a></h6>
                                    <div>{{ $comment['created_at'] }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection
