@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Категории</title>
    <meta name='description' content='Категории на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='категория, категории, изменение, удаление, добавление' />
    <link rel='stylesheet' href='{{ asset('styles/pages/category/list.css') }}'>
    <script src='{{ asset('js/pages/category/list.js') }}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Категории</h1>

            <x-panel-lk />

            <div class="table-responsive">
                <form id="formCreateCategory">
                    <div>
                        <label for="category">Название категории</label>
                        <input type="text" name="name_category" maxlength="30" id="category">
                    </div>
                    <div>
                        <button type='submit' class='btn hoverBtn add'><span>Добавить</span></button>
                    </div>
                </form>
                <table class="table table-striped body_category">
                    <thead>
                    <tr>
                        <th scope="col">Id категории</th>
                        <th scope="col">Название</th>
                        <th scope="col"></th>
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
                            <td class='changedTd'><button type='button' class='btn hoverBtn btn-primary changed'><span>Изменить</span></button></td>
                            <td class='deletedTd'><button type='button' class='btn hoverBtn btn-danger deleted'><span>Удалить</span></button></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{ $getList->links('components.paginate') }}
    </div>

@endsection
