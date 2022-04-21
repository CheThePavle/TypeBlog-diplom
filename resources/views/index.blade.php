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
    <h1>
        @switch($order)
            @case(1)
                Старые посты
                @break
            @default
                Последние посты
        @endswitch
    </h1>
    <hr>
    <div class="row">
        <div class="col-md-8">
            <div class="posts"></div>
            <div class="msg"></div>

            <x-post-loader/>

        </div>
        <div class="col-md-4 sidebar">
            <form>
                <h3 class="header_sidebar">Сортировка</h3>
                <div class="btn-group">
                    <div class="btn-group">
                        <select name="order" >
                            <option value="1" {{ $order == 1 ? 'selected' : '' }}>Сначала старые</option>
                            <option value="0" {{ $order == 0 ? 'selected' : '' }}>Сначала новые</option>
                        </select>
                    </div>
                </div>
                <br><br>
                <h3 class="header_sidebar">Фильтр</h3>
                <p><b>Категория:</b></p>

                @if(count($getCategory) > 0)
                    @foreach($getCategory as $cat)
                        @php
                            $idCategory = $cat['id_category'];
                            $checked = ($category == $idCategory ? 'checked' : $idCategory == 1) ? 'checked' : '';
                        @endphp
                        <label class='labelCategory' for='id{{ $idCategory }}'><input id='id{{ $idCategory }}' {{ $checked }} name='category' type='radio' value='{{ $idCategory }}'> {{ $cat['name_category'] }}</label>
                    @endforeach
                @endif

                <p><b>Теги:</b></p>
                <p>
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
                                echo "<label class='labelTag' for='idT$idTag'><input id='idT$idTag' $checked type='checkbox' name='tag[]' value='$idTag'> $nameTag </label> ";
                            }
                        @endphp
                    @endif
                </p>
                <button type="submit" class="btn btn-success btn_search">Применить</button>
                <input type="button" class="btn btn-danger reset_btn" value="Сбросить">
            </form>
        </div>
    </div>
@endsection
