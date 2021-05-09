<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class Role extends Model
{
    use HasFactory;

    /*
     * Название таблицы в БД
     * @var string
     * */
    protected $table = 'role';

    /*
     * Получить всех пользователей с конкретной ролью
     * */
    public function users()
    {
        return $this->hasMany(User::class, "id_role");
    }
}
