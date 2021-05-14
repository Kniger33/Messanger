<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserChatPivot extends Pivot
{
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
     * Получить все сообщения пользователя в чате
     * */
    public function messages()
    {
        return $this->hasMany(Message::class, 'id_user');
    }

}
