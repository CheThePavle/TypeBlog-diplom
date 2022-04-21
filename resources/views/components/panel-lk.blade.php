<ul class="nav nav-tabs">
    <li class="{{ Route::is('lk') ? 'active' : '' }}"><a href="{{ route('lk') }}" data-toggle="tab">Профиль</a></li>
    <li class="{{ Route::is('post.create') ? 'active' : '' }}"><a href="{{ route('post.create') }}">Создать пост</a></li>
    <li class="{{ Route::is('user.change.password') ? 'active' : '' }}"><a href="{{ route('user.change.password') }}">Изменить пароль</a></li>
    @if (auth()->user()->isAdmin())
        <li class="{{ Route::is('post.list.all') ? 'active' : '' }}"><a href="{{ route('post.list.all') }}">Список постов</a></li>
    @endif
    @if (auth()->user()->isModer())
        <li class="{{ Route::is('post.list') ? 'active' : '' }}"><a href="{{ route('post.list') }}">Отправленные посты</a></li>
    @endif
    @if (auth()->user()->isModerOrAdmin())
        <li class="{{ Route::is('user.complaint') ? 'active' : '' }}"><a href="{{ route('user.complaint') }}">Жалобы на пользователей</a></li>
    @endif
    @if (auth()->user()->isAdmin())
        <li class="{{ Route::is('user.list') ? 'active' : '' }}"><a href="{{ route('user.list') }}">Список пользователей</a></li>
        <li class="{{ Route::is('category.list') ? 'active' : '' }}"><a href="{{ route('category.list') }}">Категории</a></li>
        <li class="{{ Route::is('tag.list') ? 'active' : '' }}"><a href="{{ route('tag.list') }}">Теги</a></li>
    @endif
</ul>
