<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use HasFactory;
    use SoftDeletes;
    /*
     * Название таблицы в БД
     * */
    protected $table = 'message';

    /**
     * Формат хранения столбцов даты модели.
     *
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:m:s';

    /*
     *
     * */
    public function user()
    {
        return $this->belongsToMany(UserChatPivot::class, 'user_chat', 'id_user', 'id_user');
    }

    /**
     * Получить вложения, прикрепленные к сообщению
     * */
    public function attachmentsInfo()
    {
        return $this->hasMany(Document::class, "id_message");
    }

}
