<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChat extends Model
{
    use HasFactory;
    /*
     * Название таблицы в БД
     * @var string
     * */
    protected $table = 'user_chat';

    /**
     * Формат хранения столбцов даты модели.
     *
     * @var string
     */
    protected $dateFormat = 'Y-d-m H:m:s';

    /*
     * Получить пользователя
     * */
    public function user()
    {
        $this->belongsTo(User::class, 'id_user');
    }

    /*
     * Получить чат
     * */
    public function chat()
    {
        $this->belongsTo(Chat::class, 'id_chat');
    }

    /*
     *
     * */
    public function messages()
    {
        $this->hasMany(Message::class);
    }
}
