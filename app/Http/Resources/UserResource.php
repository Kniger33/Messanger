<?php

namespace App\Http\Resources;

use App\Models\Role;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'role' => $this->role->name,
            'name' =>$this->first_name,
            'surname' =>$this->second_name,
            'patronymic' =>$this->patronymic,
            'deleted' => $this->is_deleted
        ];
    }
}
