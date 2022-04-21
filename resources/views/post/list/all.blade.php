@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Список постов</title>
    <meta name='description' content='Список постов на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пост, посты, редактирование, изменение, список' />
    <link rel='stylesheet' href='{{ asset('styles/pages/post/list/all.css') }}'>
    <script src='{{ asset('js/pages/post/list/all.js') }}'></script>
@endsection

@section('content')
    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active table-responsive">
                <table class="table table-striped body_posts">
                    <thead>
                        <tr>
                            <th scope="col">Id поста</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Создатель</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Дата и время создания</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($getList as $list)
                        <tr class='id_post' data-id='{{ $list['id_post'] }}'>
                            <th scope='row'><a href='{{ route('post', ['id' => $list['id_post']]) }}' target='_blank'>{{ $list['id_post'] }}</a></th>
                            <td>{{ $list['heading'] }}</td>
                            <td><a href='{{ route('profile', ['id' => $list['id_user']]) }}' target='_blank'>{{ $list['login'] }}</a></td>
                            <td>{{ $list['name'] }}</td>
                            <td>{{ $list['created_at'] }}</td>
                            @if($list['code'] == 'published')
                                <td class='rejectedTd'><button type='button' class='btn btn-warning rejected'>Отклонить</button></td>
                            @else
                                <td class='publishedTd'><button type='button' class='btn btn-success published'>Опубликовать</button></td>
                            @endif
                            <td><a href='{{ route('post.change', ['id' => $list['id_post']]) }}' target='_blank'><button type='button' class='btn btn-primary changed'>Изменить</button></a></td>
                            <td><button type='button' class='btn btn-danger deleted'>Удалить</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
