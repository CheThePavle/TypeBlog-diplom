@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Жалобы на пользователей</title>
    <meta name='description' content='Жалобы пользователей на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пользователь, пользователи, изменение, список, блокировка, жалоба, жалобы' />
    <link rel='stylesheet' href='{{ asset('styles/pages/user/complaint.css') }}'>
    <script src='{{ asset('js/pages/user/complaint.js') }}'></script>
@endsection

@section('content')

    <div class="tabbable">

        <x-panel-lk />

        <div class="tab-content">
            <div class="tab-pane active table-responsive">
                <table class="table table-striped body_complaints">
                    <thead>
                        <tr>
                            <th scope="col">Id жалобы</th>
                            <th scope="col">Причина</th>
                            <th scope="col">Обвиняемый</th>
                            <th scope="col">Отправитель</th>
                            <th scope="col">Дата жалобы</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($treeComplaint as $branch)
                        @if(count($branch) === 1)
                        <tr class='id_complaint' data-id='{{ $branch[0]['id_complaint'] }}'>
                            <th>{{ $branch[0]['id_complaint'] }}</th>
                            <td>{{ $branch[0]['body_complaint'] }}</td>
                            <td><a href='{{ route('profile', ['id' => $branch[0]['id_accused']]) }}' target='_blank'>{{ $branch[0]['accused'] }}</a></td>
                            <td><a href='{{ route('profile', ['id' => $branch[0]['id_witness']]) }}' target='_blank'>{{ $branch[0]['witness'] }}</a></td>
                            <td>{{ $branch[0]['created_at'] }}</td>
                            <td><button type='button' class='btn btn-danger blocked'>Заблокировать</button></td>
                            <td><button type='button' class='btn btn-success rejected'>Отклонить</button></td>
                        </tr>
                        @else
                            <tr class='more id_complaint' data-id='{{ $branch[0]['id_complaint'] }}'>
                                <td><i class='glyphicon glyphicon-plus glyphicon{{ $branch[0]['id_complaint'] }}'></i></td>
                                <td></td>
                                <td><a href='{{ route('profile', ['id' => $branch[0]['id_accused']]) }}' target='_blank'>{{ $branch[0]['accused'] }}</td>
                                <td></td>
                                <td></td>
                                <td><button type='button' class='btn btn-danger blocked'>Заблокировать</button></td>
                                <td><button type='button' class='btn btn-success rejected'>Отклонить</button></td>
                            </tr>
                            @foreach($branch as $item)
                                <tr class='collapse row{{ $branch[0]['id_complaint'] }}'>
                                    <th>{{ $item['id_complaint'] }}</a></th>
                                    <td>{{ $item['body_complaint'] }}</td>
                                    <td></td>
                                    <td><a href='{{ route('profile', ['id' => $item['id_witness']]) }}' target='_blank'>{{ $item['witness'] }}</a></td>
                                    <td>{{ $item['created_at'] }}</td>
                                </tr>
                            @endforeach
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
