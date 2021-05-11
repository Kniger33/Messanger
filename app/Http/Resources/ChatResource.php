<?php

namespace App\Http\Resources;

use App\Models\ChatType;
use App\Models\Message;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
{
    /**
     * Указывает, следует ли сохранить ключи коллекции ресурса.
     *
     * @var bool
     */
    public $preserveKeys = true;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $chat_type = ChatType::find($this->id_chat_type)->name;
        $messages_count = Message::all()->where('id_chat', '=', '2')->count();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'messages_count' => $messages_count,
            'deleted' => $this->isDeleted,
            'chat_type' => $chat_type,
            'participants_number' => $this->participants_number,
        ];
    }
}
