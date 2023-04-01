<?php

namespace App\Http\Resources;
use App\Models\Language;
use App\Models\Critic;
use App\Models\Actor;
use App\Models\Film;

use Illuminate\Http\Resources\Json\JsonResource;

class FilmResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request):array
    {
        if ($request->routeIs('films.showActor')) {
            
            return[
                'acteurs' => $this->actors()->get(),
            ];
        }
        else {
                
            return [
                'id'=>$this->id,
                'titre'=>$this->title,
                'année'=> $this-> release_year,
                'langue' => Language::find($this->language_id)->name,
                'durée (min)'=> $this->length,
                'évaluation' => $this->rating,
                'caractéristiques spéciales' => $this->special_features,
                'image'=> $this->image,
                'critiques' => $this->when($request->routeIs('films.show'),$this->critics()->get()),
            ];
        }
    }
}
