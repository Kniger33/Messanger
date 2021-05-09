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
    public function userChat()
    {
        return $this->belongsTo(UserChat::class, );
    }

    public function documents()
    {
        return $this->hasMany(Document::class, "id_message");
    }

}
