<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Models\Role;

//laravel программное удаление

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Название таблицы в БД
     * @var string
     * */
    protected $table = 'user';

    /**
     * Формат хранения столбцов даты модели.
     *
     * @var string
     */
    protected $dateFormat = 'Y-d-m H:m:s';

    /**
     * Получить роль пользователя
     * */
    public function role()
    {
        return $this->belongsTo(Role::class, "id_role");
    }

    /**
     * Получить все чаты пользователя
     * */
    public function chats()
    {
        return $this->belongsToMany(Chat::class, "user_chat",
                                "id_user", "id_chat")
            ->using(UserChatPivot::class)
            ->withPivot('is_new_message');
    }
//    /**
//     * The attributes that are mass assignable.
//     *
//     * @var array
//     */
//    protected $fillable = [
//        'name',
//        'email',
//        'password',
//    ];


}
