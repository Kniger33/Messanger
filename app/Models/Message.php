<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;
    /*
     * Название таблицы в БД
     * */
    protected $table = 'message';

    /*
     *
     * */
    public function user()
    {
        return $this->belongsToMany(UserChatPivot::class, 'user_chat', 'id_user', 'id_user');
    }

    /*
     * Получить документы, прикрепленные к сообщению
     * */
    public function documents()
    {
        return $this->hasMany(Document::class, "id_message");
    }

}
