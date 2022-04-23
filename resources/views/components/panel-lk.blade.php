<div class="navLk">
    <a href="{{ route('lk') }}" class="btn hoverBtn {{ Route::is('lk') ? 'activeLinkLk' : '' }}"><span>Профиль</span></a>
    <a href="{{ route('post.create') }}" class="btn hoverBtn {{ Route::is('post.create') ? 'activeLinkLk' : '' }}"><span>Создать пост</span></a>
    <a href="{{ route('user.change.password') }}" class="btn hoverBtn {{ Route::is('user.change.password') ? 'activeLinkLk' : '' }}"><span>Изменить пароль</span></a>
    @if (auth()->user()->isAdmin())
        <a href="{{ route('post.list.all') }}" class="btn hoverBtn {{ Route::is('post.list.all') ? 'activeLinkLk' : '' }}"><span>Список постов</span></a>
    @endif
    @if (auth()->user()->isModer())
        <a href="{{ route('post.list') }}" class="btn hoverBtn {{ Route::is('post.list') ? 'activeLinkLk' : '' }}"><span>Отправленные посты</span></a>
    @endif
    @if (auth()->user()->isModerOrAdmin())
        <a href="{{ route('user.complaint') }}" class="btn hoverBtn {{ Route::is('user.complaint') ? 'activeLinkLk' : '' }}"><span>Жалобы на пользователей</span></a>
    @endif
    @if (auth()->user()->isAdmin())
        <a href="{{ route('user.list') }}" class="btn hoverBtn {{ Route::is('user.list') ? 'activeLinkLk' : '' }}"><span>Список пользователей</span></a>
        <a href="{{ route('category.list') }}" class="btn hoverBtn {{ Route::is('category.list') ? 'activeLinkLk' : '' }}"><span>Категории</span></a>
        <a href="{{ route('tag.list') }}" class="btn hoverBtn {{ Route::is('tag.list') ? 'activeLinkLk' : '' }}"><span>Теги</span></a>
    @endif
</div>
