@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Теги</title>
    <meta name='description' content='Теги на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='тег, теги, изменение, удаление' />
    <link rel='stylesheet' href='{{ asset('styles/pages/tag/list.css') }}'>
@endsection

@section('scripts')
    <script src='{{ asset('js/pages/tag/list.js') }}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Теги</h1>

            <x-panel-lk />

            <div class="table-responsive">
                <table class="table table-striped body_tag minWTable">
                    <thead>
                    <tr>
                        <th scope="col">Id тега</th>
                        <th scope="col">Название</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getList as $list)
                        <tr class='id_tag' data-id='{{ $list['id_tag'] }}'>
                            <th scope='row'>{{ $list['id_tag'] }}</th>
                            <td class="body_val_tag"><span class="val_tag">{{ $list['name_tag'] }}</span><div class='body_change_tag'></div></td>
                            @if($list['public_tag'] == '1')
                                <td class='unpublishedTd'><button type='button' class='btn hoverBtn unpublished'><span>Скрыть</span></button></td>
                            @else
                                <td class='publishedTd'><button type='button' class='btn hoverBtn published'><span>Опубликовать</span></button></td>
                            @endif
                            <td class='deletedTd'><button type='button' class='btn hoverBtn changed'><span>Изменить</span></button></td>
                            <td class='deletedTd'><button type='button' class='btn hoverBtn deleted'><span>Удалить</span></button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                @if (count($getList) < 1)
                    <div class="text-center">Теги не найдены</div>
                @endif
            </div>
        </div>

        {{ $getList->links('components.paginate') }}
    </div>

@endsection
