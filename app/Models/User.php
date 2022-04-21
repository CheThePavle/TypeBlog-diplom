<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'user';
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'id_role',
        'email',
        'login',
        'password',
        'about',
        'folder',
        'img_type',
        'blocked',
    ];

    protected $hidden = [
        'password',
    ];

    public function isModer() {
        $id = Auth::check() ? Auth::user()->id_user : false;
        if (!$id) return false;

        $check = User::where('id_user', $id)->where('id_role', 2)->first();
        if (!$check) return false;
        return true;
    }

    public function isAdmin() {
        $id = Auth::check() ? Auth::user()->id_user : false;
        if (!$id) return false;

        $check = User::where('id_user', $id)->where('id_role', 3)->first();
        if (!$check) return false;
        return true;
    }

    public function isModerOrAdmin() {
        $id = Auth::check() ? Auth::user()->id_user : false;
        if (!$id) return false;

        $check = User::where('id_user', $id)
            ->first();
        if ($check) {
            if ($check->id_role === 2 || $check->id_role === 3) {
                return true;
            }
        }
        return false;
    }

    public function getRoleRus() {
        $idRole = Auth::check() ? Auth::user()->id_role : 'Неизвестно';
        if (!$idRole) return 'Неизвестно';

        $name = UserRole::where('id_role', $idRole)->first();
        return isset($name['name']) ? $name['name'] : 'Неизвестно';
    }
}
