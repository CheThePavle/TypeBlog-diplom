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

Route::get('/error/{number}', [ErrorController::class, 'show'])->name('error');

Route::get('/post/findById', [PostController::class, 'findById']);
Route::get('/post/search', [PostController::class, 'search']);
Route::get('/post/searchProfile', [PostController::class, 'searchProfile']);
Route::get('/post/searchLk', [PostController::class, 'searchLk']);
Route::get('/post/random', [PostController::class, 'random']);
Route::get('/post/searchPostAndUser', [PostController::class, 'searchPostAndUser']);
Route::get('/post/list', [PostController::class, 'showList'])->name('post.list');
Route::get('/post/list/all', [PostController::class, 'showListAll'])->name('post.list.all');
Route::get('/post/create', [PostController::class, 'showCreate'])->name('post.create');
Route::post('/post/like', [PostController::class, 'like']);
Route::post('/post/dislike', [PostController::class, 'dislike']);
Route::post('/post/published', [PostController::class, 'published']);
Route::post('/post/rejected', [PostController::class, 'rejected']);
Route::post('/post/delete', [PostController::class, 'delete']);
Route::post('/post/create', [PostController::class, 'create']);
Route::post('/post/change', [PostController::class, 'change']);
Route::post('/post/findBodyById', [PostController::class, 'findBodyById']);
Route::get('/post/change/{id}', [PostController::class, 'showChange'])->name('post.change');
Route::get('/post/{id}', [PostController::class, 'show'])->name('post');

Route::get('/login', [UserController::class, 'showLogin'])->name('login');
Route::get('/register', [UserController::class, 'showRegister'])->name('register');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');
Route::get('/user/change/password', [UserController::class, 'showChangePassword'])->name('user.change.password');
Route::get('/user/complaint', [UserController::class, 'showComplaint'])->name('user.complaint');
Route::get('/user/list', [UserController::class, 'showList'])->name('user.list');
Route::post('/user/blocked', [UserController::class, 'blocked']);
Route::post('/user/unblocked', [UserController::class, 'unblocked']);
Route::post('/user/changeRoleById', [UserController::class, 'changeRoleById']);
Route::post('/user/blockedComplaint', [UserController::class, 'blockedComplaint']);
Route::post('/user/rejectedComplaint', [UserController::class, 'rejectedComplaint']);
Route::post('/user/change/password', [UserController::class, 'changePassword']);
Route::post('/user/findLogin', [UserController::class, 'findLogin']);
Route::post('/user/findEmail', [UserController::class, 'findEmail']);
Route::post('/user/create', [UserController::class, 'create']);
Route::post('/user/auth', [UserController::class, 'auth']);
Route::post('/user/complaint', [UserController::class, 'complaint']);
Route::post('/user/changeEmailAndAbout', [UserController::class, 'changeEmailAndAbout']);
Route::post('/user/setAvatar', [UserController::class, 'setAvatar']);

Route::get('/profile/{id}', [ProfileController::class, 'show'])->name('profile');

Route::get('/lk', [LkController::class, 'show'])->name('lk');

Route::get('/category/list', [CategoryController::class, 'show'])->name('category.list');
Route::post('/category/change', [CategoryController::class, 'change']);
Route::post('/category/create', [CategoryController::class, 'create']);
Route::post('/category/delete', [CategoryController::class, 'delete']);

Route::get('/tag/list', [TagController::class, 'show'])->name('tag.list');
Route::post('/tag/change', [TagController::class, 'change']);
Route::post('/tag/delete', [TagController::class, 'delete']);
Route::post('/tag/published', [TagController::class, 'published']);
Route::post('/tag/unpublished', [TagController::class, 'unpublished']);
Route::post('/tag/findByPostId', [TagController::class, 'findByPostId']);

Route::get('/comment/findByPostId', [CommentController::class, 'findByPostId']);
Route::post('/comment/like', [CommentController::class, 'like']);
Route::post('/comment/dislike', [CommentController::class, 'dislike']);
Route::post('/comment/delete', [CommentController::class, 'delete']);
Route::post('/comment/create', [CommentController::class, 'create']);
Route::post('/comment/change', [CommentController::class, 'change']);
Route::post('/comment/createReply', [CommentController::class, 'createReply']);

