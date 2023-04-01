<?php

namespace App\Models;
use App\Models\Actor;
use App\Models\Language;
use App\Models\Critic;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Film extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'title',
        'release_year',
        'description',
        'rating',
        'length',
        'language_id',
        'special_features',
        'image',
        'created_at',
        
    ];
  
   /**
    * The actors that belong to the Film
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
   public function actors()
   {
       return $this->belongsToMany(Actor::class);
   }
   /**
    * Get the language associated with the Film
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
   public function language()
   {
       return $this->hasOne(Language::class);
   }

   /**
    * Get all of the critics for the Film
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
   public function critics()
   {
       return $this->hasMany(Critic::class);
   }
}
