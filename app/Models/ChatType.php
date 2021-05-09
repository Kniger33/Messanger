<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Chat;

class ChatType extends Model
{
    use HasFactory;
    /*
     * Название таблицы в БД
     * @var string
     * */
    protected $table ='chat_type';

    /*
     * Получить чаты определенного типа
     * */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'id_chat_type');
    }
}
