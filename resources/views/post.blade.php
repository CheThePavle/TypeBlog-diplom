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
    <h1 id="heading">Заголовок</h1>
    <hr>
    <div class="row">
        <div class="col-md-12 body_post">
            <div class="msg"></div>
            <div class="prevPost"></div>
            <div id="editorjs"></div>
            <div class="likesPost"></div>
            <div class="repost">
                <h3>Поделиться в соц. сетях</h3>
                <div class="ya-share2" data-curtain data-shape="round" data-limit="5" data-services="vkontakte,telegram,odnoklassniki,twitter,whatsapp,facebook,messenger,viber,moimir,skype,tumblr,evernote,linkedin,lj,blogger,delicious,digg,reddit,pocket,qzone,renren,sinaWeibo,surfingbird,tencentWeibo"></div>
            </div>
            <div id="qrcode"></div>
        </div>
    </div>

    <x-comments />
@endsection
