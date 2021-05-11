<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ChatType;

class Chat extends Model
{
    use HasFactory;

    /*
     * Название таблицы в БД
     * @var string
     * */
    protected $table = 'chat';

    /*
     * Получить тип чата
     * */
    public function chatType()
    {
        return $this->belongsTo(ChatType::class, 'id_chat_type');
    }

    /*
     *Получить всех пользователей чата
     * */
    public function users()
    {
        return $this->belongsToMany(User::class, "user_chat",
            "id_chat", "id_user")
            ->using(UserChatPivot::class)
            ->withPivot('is_new_message');
    }

}
