<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $fillable = [
        'last_name',
        'first_name',
        'email',
        'password',
        'role_id',
    ];
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom'=>$this->last_name,
            'prénom'=> $this->first_name,
            'courriel'=>$this->email,
            'rôle'=> $this->role->name,
            
        ];
    }
}
