<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChat extends Pivot
{
    /*
     * Название таблицы в БД
     * @var string
     * */
    protected $table = 'user_chat';

    /*
     * Получить все сообщения пользователя в чате
     * */
    public function messages()
    {
        return $this->hasMany(Message::class,  ["id_user", "id_chat"]);
    }

}