@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Теги</title>
    <meta name='description' content='Теги на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='тег, теги, изменение, удаление' />
    <link rel='stylesheet' href='{{ asset('styles/pages/tag/list.css') }}'>
    <script src='{{ asset('js/pages/tag/list.js') }}'></script>
@endsection

@section('content')
    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active table-responsive">
                <table class="table table-striped body_tag">
                    <thead>
                        <tr>
                            <th scope="col">Id тега</th>
                            <th scope="col">Название</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($getList as $list)
                        <tr class='id_tag' data-id='{{ $list['id_tag'] }}'>
                            <th scope='row'>{{ $list['id_tag'] }}</th>
                            <td class='val_tag'>{{ $list['name_tag'] }}</td>
                        @if($list['public_tag'] == '1')
                            <td class='unpublishedTd'><button type='button' class='btn btn-warning unpublished'>Скрыть</button></td>
                        @else
                            <td class='publishedTd'><button type='button' class='btn btn-success published'>Опубликовать</button></td>
                        @endif
                            <td class='body_change_tag'></td>
                            <td class='deletedTd'><button type='button' class='btn btn-primary changed'>Изменить</button></td>
                            <td class='deletedTd'><button type='button' class='btn btn-danger deleted'>Удалить</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
