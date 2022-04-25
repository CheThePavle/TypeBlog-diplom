@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Главная</title>
    <meta name='description' content='Все посты сайта - {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='главная, посты, фильтры' />
    <link rel='stylesheet' href='{{ asset('styles/pages/index.css') }}'>
    <script src='{{ asset('js/pages/index.js') }}'></script>
    <link rel='stylesheet' href='{{ asset('styles/components/postLoader.css') }}'>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">
                @switch($order)
                    @case(1)
                    Старые посты
                    @break
                    @default
                    Последние посты
                @endswitch
            </h1>
            <div class="col-lg-8">
                <div class="posts"></div>
                <div class="msg"></div>

                <x-post-loader/>

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
                <form class="sidebarItem filterSidebar">
                    <div>
                        <h5>Сортировка</h5>
                        <select class="select" name="order">
                            <option disabled>Выбрать</option>
                            <option value="1" {{ $order == 1 ? 'selected' : '' }}>Сначала старые</option>
                            <option value="0" {{ $order == 0 ? 'selected' : '' }}>Сначала новые</option>
                        </select>
                    </div>
                    <div>
                        <h5>Категория</h5>
                        <div class="category">
                            @if(count($getCategory) > 0)
                                @foreach($getCategory as $cat)
                                    @php
                                        $idCategory = $cat['id_category'];
                                        $checked = ($category == $idCategory ? 'checked' : $idCategory == 1) ? 'checked' : '';
                                    @endphp
                                    <div>
                                        <input type="radio" class="btn-check" name="category" id='id{{ $idCategory }}' value='{{ $idCategory }}' {{ $checked }}>
                                        <label class="btn btn-secondary labelCategory" for="id{{ $idCategory }}">{{ $cat['name_category'] }} <span class="countCategory">{{ $loop->first ? $getCountDefaultCategory : $cat['count'] }}</span></label>
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
                                        if ($tag) {
                                            foreach ($tag as $el) {
                                                foreach ($getTag as &$item) {
                                                    if ($el == $item['id_tag']) {
                                                        $item['checked'] = true;
                                                    }
                                                }
                                            }
                                        }
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
{{--                <div class="sidebarItem">--}}
{{--                    <h5>Популярные посты</h5>--}}
{{--                    <div>--}}
{{--                        <div class="newItem">--}}
{{--                            <img src="assets/imgs/1.jpg" alt="">--}}
{{--                            <div class="newBody">--}}
{{--                                <div class="date">April 1, 2019</div>--}}
{{--                                <h6>10 Amazing new games</h6>--}}
{{--                                <div class="meta">--}}
{{--                                    <div>By Admin</div>--}}
{{--                                    <div>in <a href="#">Games</a></div>--}}
{{--                                    <div>3 Comments</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="newItem">--}}
{{--                            <img src="assets/imgs/1.jpg" alt="">--}}
{{--                            <div class="newBody">--}}
{{--                                <div class="date">April 1, 2019</div>--}}
{{--                                <h6>10 Amazing new games</h6>--}}
{{--                                <div class="meta">--}}
{{--                                    <div>By Admin</div>--}}
{{--                                    <div>in <a href="#">Games</a></div>--}}
{{--                                    <div>3 Comments</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="newItem">--}}
{{--                            <img src="assets/imgs/1.jpg" alt="">--}}
{{--                            <div class="newBody">--}}
{{--                                <div class="date">April 1, 2019</div>--}}
{{--                                <h6>10 Amazing new games</h6>--}}
{{--                                <div class="meta">--}}
{{--                                    <div>By Admin</div>--}}
{{--                                    <div>in <a href="#">Games</a></div>--}}
{{--                                    <div>3 Comments</div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
