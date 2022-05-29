@extends('layouts.layout')

@section('head')
    <title>{{ env('NAME_SITE') }} - Список пользователей</title>
    <meta name='description' content='Список пользователей на сайте {{ env('NAME_SITE') }}'>
    <meta name='keywords' content='пользователь, пользователи, изменение, список, блокировка' />
    <link rel='stylesheet' href='{{ asset('styles/pages/user/list.css') }}'>
@endsection

@section('scripts')
    <script src='{{ asset('js/pages/user/list.js')}}'></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h1 class="text-center title">Список пользователей</h1>

            <x-panel-lk />

            <div class="table-responsive">
                <table class="table table-striped body_users">
                    <thead>
                    <tr>
                        <th scope="col">Id пользователя</th>
                        <th scope="col">Email</th>
                        <th scope="col">Логин</th>
                        <th scope="col">Роль</th>
                        <th scope="col">Дата и время регистрации</th>
                        <th scope="col"></th>
                    </tr>
                    </thead>
                    <tbody>

                    @php
                        $roleHTML = '';
                        foreach ($getList as $el) {
                            $idUser = $el['id_user'];
                            $emailUser = $el['email'];
                            $loginUser = $el['login'];
                            $createdAtUser = $el['created_at'];
                            $blockedUser = $el['blocked'];

                            foreach ($getRole as $item) {
                                $idRole = $item['id_role'];
                                if ($item['id_role'] == $el['id_role']) {
                                    $roleHTML = $roleHTML . "<option value='$idRole' selected>". $item['name'] ."</option>";
                                } else {
                                    $roleHTML = $roleHTML . "<option value='$idRole'>". $item['name'] ."</option>";
                                }
                            }

                            echo "<tr class='id_user' data-id='$idUser'>";
                            echo "<th scope='row'><a href='/profile/$idUser' target='_blank'>$idUser</a></th>";
                            echo "<td>$emailUser</td>";
                            echo "<td><a href='/profile/$idUser' target='_blank'>$loginUser</a></td>";
                            echo "<td><select class='change_role defaultSelect' name='role'>". $roleHTML ."</select></td>";
                            echo "<td>$createdAtUser</td>";
                            echo $blockedUser == '1'
                                ? "<td class='unblockedTd'><button type='button' class='btn hoverBtn btn-success unblocked'><span>Разблокировать</span></button></td>"
                                : "<td class='blockedTd'><button type='button' class='btn hoverBtn btn-danger blocked'><span>Заблокировать</span></button></td>";
                            echo "</tr>";

                            $roleHTML = '';
                        }
                    @endphp
                    </tbody>
                </table>
            </div>
        </div>

        {{ $getList->links('components.paginate') }}
    </div>

@endsection
