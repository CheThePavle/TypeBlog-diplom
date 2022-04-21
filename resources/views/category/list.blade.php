@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Категории</title>
    <meta name='description' content='Категории на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='категория, категории, изменение, удаление, добавление' />
    <link rel='stylesheet' href='{{ asset('styles/pages/category/list.css') }}'>
    <script src='{{ asset('js/pages/category/list.js') }}'></script>
@endsection

@section('content')
    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active table-responsive">
                <form id="formCreateCategory">
                    <br>
                    <div class="form-group col-md-3">
                        <input class="form-control" type="text" name="name_category" maxlength="30">
                    </div>
                    <button type='submit' class='btn btn-success add'>Добавить</button>
                    <br>
                </form>
                <table class="table table-striped body_category">
                    <thead>
                    <tr>
                        <th scope="col">Id категории</th>
                        <th scope="col">Название</th>
                        <th scope="col"></th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($getList as $list)
                        <tr class='id_category' data-id='{{ $list['id_category'] }}'>
                            <th scope='row'>{{ $list['id_category'] }}</th>
                            <td class='val_category'>{{ $list['name_category'] }}</td>
                            <td class='body_change_category'></td>
                            <td class='changedTd'><button type='button' class='btn btn-primary changed'>Изменить</button></td>
                            <td class='deletedTd'><button type='button' class='btn btn-danger deleted'>Удалить</button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
