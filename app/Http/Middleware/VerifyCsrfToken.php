<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        '/user/findLogin',
        '/user/findEmail',
        '/user/create',
        '/user/auth',
        '/user/complaint',
        '/user/changeEmailAndAbout',
        '/user/setAvatar',
        '/user/change/password',
        '/user/blockedComplaint',
        '/user/rejectedComplaint',
        '/user/changeRoleById',
        '/user/unblocked',
        '/user/blocked',
        '/post/like',
        '/post/dislike',
        '/post/published',
        '/post/rejected',
        '/post/delete',
        '/post/create',
        '/post/change',
        '/post/findBodyById',
        '/comment/like',
        '/comment/dislike',
        '/comment/delete',
        '/comment/create',
        '/comment/change',
        '/comment/createReply',
        '/category/change',
        '/category/create',
        '/category/delete',
        '/tag/change',
        '/tag/delete',
        '/tag/published',
        '/tag/unpublished',
        '/tag/findByPostId',
    ];
}
