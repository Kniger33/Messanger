<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    /*
     * Название таблицы в БД
     * */
    protected $table = 'document';

    /**
     * Формат хранения столбцов даты модели.
     *
     * @var string
     */
    protected $dateFormat = 'Y-d-m H:m:s';

    /*
     * Получить сообщение, к которому привязан документ
     * */
    public function message()
    {
        return $this->belongsTo(Message::class, 'id_message');
    }

}
