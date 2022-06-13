<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\LkController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [IndexController::class, 'show'])->name('/');
Route::post('/changeTheme', [IndexController::class, 'changeTheme']);

Route::get('/error/{number}', [ErrorController::class, 'show'])->name('error');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/captcha', [UserController::class, 'genCaptcha'])->name('captcha');
Route::get('/reset/password', [UserController::class, 'showResetPassword'])->name('reset.password');
Route::post('/reset/password', [UserController::class, 'resetPassword'])->name('reset.password');

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile');

Route::get('/lk', [LkController::class, 'show'])->name('lk');

Route::prefix('post')->group(function () {
    Route::get('/findById', [PostController::class, 'findById']);
    Route::get('/search', [PostController::class, 'search']);
    Route::get('/searchProfile', [PostController::class, 'searchProfile']);
    Route::get('/searchLk', [PostController::class, 'searchLk']);
    Route::get('/random', [PostController::class, 'random']);
    Route::get('/searchPostAndUser', [PostController::class, 'searchPostAndUser']);
    Route::get('/list', [PostController::class, 'showList'])->name('post.list');
    Route::get('/list/all', [PostController::class, 'showListAll'])->name('post.list.all');
    Route::get('/create', [PostController::class, 'showCreate'])->name('post.create');
    Route::post('/like', [PostController::class, 'like']);
    Route::post('/dislike', [PostController::class, 'dislike']);
    Route::post('/published', [PostController::class, 'published']);
    Route::post('/rejected', [PostController::class, 'rejected']);
    Route::post('/delete', [PostController::class, 'delete']);
    Route::post('/create', [PostController::class, 'create']);
    Route::post('/change', [PostController::class, 'change']);
    Route::post('/findBodyById', [PostController::class, 'findBodyById']);
    Route::get('/change/{id}', [PostController::class, 'showChange'])->name('post.change');
    Route::get('/{id}', [PostController::class, 'show'])->name('post');
});

Route::prefix('user')->group(function () {
    Route::get('/change/password', [UserController::class, 'showChangePassword'])->name('user.change.password');
    Route::get('/complaint', [UserController::class, 'showComplaint'])->name('user.complaint');
    Route::get('/list', [UserController::class, 'showList'])->name('user.list');
    Route::post('/blocked', [UserController::class, 'blocked']);
    Route::post('/unblocked', [UserController::class, 'unblocked']);
    Route::post('/changeRoleById', [UserController::class, 'changeRoleById']);
    Route::post('/blockedComplaint', [UserController::class, 'blockedComplaint']);
    Route::post('/rejectedComplaint', [UserController::class, 'rejectedComplaint']);
    Route::post('/change/password', [UserController::class, 'changePassword']);
    Route::post('/findLogin', [UserController::class, 'findLogin']);
    Route::post('/findEmail', [UserController::class, 'findEmail']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/auth', [UserController::class, 'auth']);
    Route::post('/complaint', [UserController::class, 'complaint']);
    Route::post('/changeEmailAndAbout', [UserController::class, 'changeEmailAndAbout']);
    Route::post('/setAvatar', [UserController::class, 'setAvatar']);
});

Route::prefix('category')->group(function () {
    Route::get('/list', [CategoryController::class, 'show'])->name('category.list');
    Route::post('/change', [CategoryController::class, 'change']);
    Route::post('/create', [CategoryController::class, 'create']);
    Route::post('/delete', [CategoryController::class, 'delete']);
});

Route::prefix('tag')->group(function () {
    Route::get('/list', [TagController::class, 'show'])->name('tag.list');
    Route::post('/change', [TagController::class, 'change']);
    Route::post('/delete', [TagController::class, 'delete']);
    Route::post('/published', [TagController::class, 'published']);
    Route::post('/unpublished', [TagController::class, 'unpublished']);
    Route::post('/findByPostId', [TagController::class, 'findByPostId']);
});

Route::prefix('comment')->group(function () {
    Route::get('/findByPostId', [CommentController::class, 'findByPostId']);
    Route::post('/like', [CommentController::class, 'like']);
    Route::post('/dislike', [CommentController::class, 'dislike']);
    Route::post('/delete', [CommentController::class, 'delete']);
    Route::post('/create', [CommentController::class, 'create']);
    Route::post('/change', [CommentController::class, 'change']);
    Route::post('/createReply', [CommentController::class, 'createReply']);
});
